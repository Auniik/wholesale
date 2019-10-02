<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\PurchaseRequest;
use App\Models\InventoryBrand;
use App\Models\InventoryProduct;
use App\Models\InventoryProductPurchase;
use App\Models\InventoryProductPurchaseItem;
use Illuminate\Http\Request;
use DB;

class InventoryProductPurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:pharmacy-purchase-list')->only('index');
        $this->middleware('can:pharmacy-purchase-create')->only('store', 'create');
        $this->middleware('can:pharmacy-purchase-show')->only('show');
        $this->middleware('can:pharmacy-purchase-delete')->only('destroy');
//        $this->middleware('can:pharmacy-purchase-approve')->only('edit', 'update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pharmacy.purchase.index',[
            'purchases' => InventoryProductPurchase::where('company_id', company_id())->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $challan_id = InventoryProductPurchase::latest()->value('challan_id');
        return view('pharmacy.purchase.create', [
            'challan_id' => $challan_id ? $challan_id += 1 : $challan_id = date('Ymd') . 1,
            'manufacturers' => InventoryBrand::where('company_id', company_id())->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request)
    {
        $purchase = $request->store();
        if ($purchase){
            return redirect()->route('inventory-product-purchases.show', $purchase->id)->withSuccess('Purchased Successfully!');
        }
        return back()->withErrors('Quantity Not added into any products');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryProductPurchase  $inventoryProductPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryProductPurchase $inventoryProductPurchase)
    {
        return view('pharmacy.purchase.show', [
            'inventoryProductPurchase' => $inventoryProductPurchase,
            'company' => auth()->user()->companyInfo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryProductPurchase  $inventoryProductPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryProductPurchase $inventoryProductPurchase)
    {
        return view('pharmacy.purchase.edit', [
            'inventoryProductPurchase' => $inventoryProductPurchase,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryProductPurchase  $inventoryProductPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseRequest $request, InventoryProductPurchase $inventoryProductPurchase)
    {
        $request->approve($inventoryProductPurchase);
        return redirect()->route('inventory-product-purchases.index')->withSuccess('Purchase Approved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryProductPurchase $inventoryProductPurchase
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(InventoryProductPurchase $inventoryProductPurchase)
    {

        $inventoryProductPurchase->delete();
        return response([
            'check' => true
        ]);
    }


    public function purchasableProducts(Request $request)
    {
        return view('pharmacy.purchase.ajax.products', [
            'products' => InventoryProduct::where('company_id', company_id())->where('brand_id', $request->id)->get()
        ]);
    }

    public function productDelete(InventoryProductPurchaseItem $item)
    {
        $item->delete();
        return 'Product deleted successfully!';
    }

}
