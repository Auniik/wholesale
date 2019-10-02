<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\SalesRequest;
use App\Models\InventoryProduct;
use App\Models\InventoryProductSale;
use App\Models\Patient;
use App\Traits\HospitalPaymentTrait;
use Illuminate\Http\Request;
use DB;

class InventoryProductSalesController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sales = InventoryProductSale::where('company_id', company_id());
        if ($request->filled('patient_id')){
            $sales->where('patient_id', $request->patient_id);
        }
        if ($request->filled('invoice_id')){
            $sales->where('invoice_id', $request->invoice_id);
        }

        return view('pharmacy.sales.index',[
            'sales' => $sales->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        InventoryProductSale::latest()
            ->value('invoice_id') ? $invoice_id = InventoryProductSale::latest()
            ->value('invoice_id') : $invoice_id = 1000;
        return view('pharmacy.sales.create', compact('invoice_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesRequest $request)
    {
        $invoice = $request->persist();
        return redirect()->route('inventory-product-sales.show', $invoice)->withSuccess('Product Sold Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryProductSale  $inventoryProductSale
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryProductSale $inventoryProductSale)
    {
        return view('pharmacy.sales.show', [
            'inventoryProductSale' => $inventoryProductSale,
            'company' => auth()->user()->companyInfo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryProductSale  $inventoryProductSale
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryProductSale $inventoryProductSale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryProductSale  $inventoryProductSale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryProductSale $inventoryProductSale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryProductSale  $inventoryProductSale
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryProductSale $inventoryProductSale)
    {

        $inventoryProductSale->delete();
        return response([
            'check' => true
        ]);
    }
}
