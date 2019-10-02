<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\MedicineGeneric;
use App\Models\MedicineType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use App\Models\InventoryProduct;
use App\Models\InventoryCategory;
use App\Models\InventoryUnit;
use App\Models\InventoryBrand;
use Validator;
use Auth;

class InventoryProductController extends Controller
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
//
        return view('pharmacy.inventory.product.index', [
            'products' => InventoryProduct::with('brand', 'category', 'unit')
                ->orderByDesc('id')
                ->where('company_id', company_id())->paginate(),
            'units' => InventoryUnit::where('status',1)
                ->where('company_id', company_id())
                ->get(),
            'categories' => InventoryCategory::where('status','1')->where('company_id', company_id())->get(),
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
            'categories' => InventoryCategory::where('status', 1)->where('company_id', company_id())->get(),
            'brands' => InventoryBrand::where('status', 1)->where('company_id', company_id())->get(),
            'units' => InventoryUnit::where('status', 1)
                ->where('company_id', company_id())
                ->get()
                ->groupBy('type'),
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
        $request->validate([
                'name' => 'required|unique:inventory_products',
//                'product_id' => 'required|unique:inventory_products',
                'category_id' => 'required',
                'unit_id' => 'required',
                'wholesale_unit_id' => 'required',
                'brand_id' => 'required',
                'generic_id' => 'required',
                'medicine_type_id' => 'required',
                'pack_size' => 'required',
        ]);
        $input = $request->all();
        $input['retail_unit_tp'] = $request->retail_unit_tp ?? 0;
        $input['retail_sales_price'] = $request->retail_sales_price ?? 0;
        InventoryProduct::create($input);
        return back()->withSuccess('Product Successfully added to inventory');

    }


    /**
     * Product edit page in here.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InventoryProduct $inventoryProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryProduct $inventoryProduct)
    {
        return view('pharmacy.inventory.product.edit',compact('inventoryProduct'), [
            'categories' => InventoryCategory::where('status', 1)->where('company_id', company_id())->get(),
            'brands' => InventoryBrand::where('status', 1)->where('company_id', company_id())->get(),
            'units' => InventoryUnit::where('status', 1)
                ->where('company_id', company_id())
                ->get()
                ->groupBy('type'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  InventoryProduct $inventoryProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryProduct $inventoryProduct)
    {
        $request->validate([
            'name' => "required|unique:inventory_products,name,".$inventoryProduct->id,
            'category_id' => 'required',
            'unit_id' => 'required',
            'wholesale_unit_id' => 'required',
            'brand_id' => 'required',
            'generic_id' => 'required',
            'medicine_type_id' => 'required',
            'pack_size' => 'required',
        ]);
//        dd($request->all());
        $inventoryProduct->update($request->all());


        return back()->withSuccess('Product Information Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param InventoryProduct $inventoryProduct
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(InventoryProduct $inventoryProduct)
    {
        $inventoryProduct->delete();
        return back()->withSuccess('Product has been deleted');
    }

    public function loadDrug(Request $request)
    {
        return InventoryProduct::query()->with('category', 'unit', 'brand', 'medicineType')
            ->where('company_id', company_id())
            ->where('name', 'LIKE', "%{$request->query('name')}%")
            ->take(15)
            ->get();
    }
    public function saleableProducts(Request $request)
    {
        return InventoryProduct::with('unit')
            ->selectRaw('inventory_products.* , inventory_product_barcodes.number')
            ->where('inventory_products.company_id', company_id())
            ->where('name', 'LIKE', "%{$request->query('name')}%")
            ->leftjoin('inventory_product_barcodes', function (JoinClause $join){
                $join->on('inventory_products.id', '=', 'inventory_product_barcodes.inventory_product_id');
            })
            ->orWhere([
                ['number', $request->query('name')]
            ])
            ->take(15)
            ->get();
    }

}
