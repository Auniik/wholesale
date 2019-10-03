<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Category;
use App\Models\Inventory\Manufacturer;
use App\Models\Inventory\Product;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:inventory-settings-list')->only('index');
        $this->middleware('can:inventory-settings-create')->only('store', 'create');
        $this->middleware('can:inventory-settings-update')->only('update', 'edit');
        $this->middleware('can:inventory-settings-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pharmacy.inventory.product.index', [
            'products' => Product::with('manufacturer', 'category')
                ->orderByDesc('id')
                ->where('company_id', company_id())
                ->paginate(),
            'categories' => Category::where('status',1)
                ->where('company_id', company_id())
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pharmacy.inventory.product.create', [
            'categories' => Category::where('status', 1)
                ->where('company_id', company_id())
                ->pluck('name', 'id'),
            'manufacturers' => Manufacturer::where('status', 1)
                ->where('company_id', company_id()
                )->pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'name' => 'required|max:192|unique:products',
            'category_id' => 'required|numeric',
            'manufacturer_id' => 'required|numeric',
        ]);
        $input = $request->all();
        Product::create($input);
        return back()->withSuccess('Product Successfully added to inventory');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pharmacy.inventory.product.edit',compact('product'), [
            'categories' => Category::where('status', 1)
                ->where('company_id', company_id())
                ->pluck('name', 'id'),
            'manufacturers' => Manufacturer::where('status', 1)
                ->where('company_id', company_id())
                ->pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => "required|unique:products,name,".$product->id,
            'category_id' => 'required|numeric',
            'manufacturer_id' => 'required|numeric',
        ]);
//        dd($request->all());
        $product->update($request->all());


        return back()->withSuccess('Product Information Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response([
            'check' => true
        ]);
    }

//    public function loadDrug(Request $request)
//    {
//        return Product::query()->with('category', 'manufacturer')
//            ->where('company_id', company_id())
//            ->where('name', 'LIKE', "%{$request->query('name')}%")
//            ->take(15)
//            ->get(['id', 'name', 'quantity']);
//    }
    public function loadProduct(Request $request)
    {
        return Product::query()->with('category', 'manufacturer')
            ->where('company_id', company_id())
            ->where('name', 'LIKE', "%{$request->query('name')}%")
            ->take(15)
            ->get(['id', 'name', 'quantity']);
    }

    public function saleableProducts(Request $request)
    {
        return Product::selectRaw('products.* , barcodes.number')
            ->where('products.company_id', company_id())
            ->where('name', 'LIKE', "%{$request->query('name')}%")
            ->leftjoin('product_barcodes', function (JoinClause $join){
                $join->on('inventory_products.id', '=', 'barcodes.product_id');
            })
            ->orWhere([
                ['number', $request->query('name')]
            ])
            ->take(15)
            ->get();
    }
}
