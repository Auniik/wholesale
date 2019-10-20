<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\SalesRequest;
use App\Models\Inventory\Product;
use App\Models\Inventory\ProductSale;
use App\Models\Party;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

class ProductSaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:pharmacy-sales-list')->only('index');
        $this->middleware('can:pharmacy-sales-create')->only('store', 'create');
        $this->middleware('can:pharmacy-sales-show')->only('show');
        $this->middleware('can:pharmacy-sales-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sales = ProductSale::where('company_id', company_id());

        if ($request->filled('invoice_id')){
            $sales->where('invoice_id', $request->invoice_id);
        }
        if ($request->filled('party_id')){
            $sales->where('party_id', $request->party_id);
        }

        return view('pharmacy.sales.index',[
            'sales' => $sales->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ProductSale::latest()
            ->value('invoice_id') ? $invoice_id = ProductSale::latest()
            ->value('invoice_id') : $invoice_id = 1000;
        return view('pharmacy.sales.create', compact('invoice_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SalesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesRequest $request)
    {
        $invoice = $request->persist();
        return redirect()->route('product.sales.show', $invoice)
            ->withSuccess('Product Sold Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param ProductSale $sale
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSale $sale)
    {
        return view('pharmacy.sales.show', [
            'sale' => $sale,
            'company' => auth()->user()->companyInfo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProductSale $sale
     * @return void
     */
    public function edit(ProductSale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ProductSale $sale
     * @return void
     */
    public function update(Request $request, ProductSale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductSale $sale
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ProductSale $sale)
    {

        $sale->delete();
        return response([
            'check' => true
        ]);
    }

    public function saleableProducts(Request $request)
    {
        $products = Product::selectRaw('products.*,  barcodes.number')
            ->where('products.company_id', company_id())
            ->where('name', 'LIKE', "%{$request->query('name')}%")
            ->leftjoin('barcodes', function (JoinClause $join){
                $join->on('products.id', '=', 'barcodes.product_id');
            })
            ->orWhere([
                ['number', $request->query('name')]
            ])
            ->take(15)
            ->get();

        return response($products, 200);
    }
}
