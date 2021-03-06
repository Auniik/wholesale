<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\PurchaseRequest;
use App\Models\Inventory\Manufacturer;
use App\Models\Inventory\Product;
use App\Models\Inventory\ProductCode;
use App\Models\Inventory\ProductPurchase;
use Illuminate\Http\Request;

class ProductPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $purchases = ProductPurchase::where('company_id', company_id());
        if ($request->filled('manufacturer_id')){
            $purchases->where('manufacturer_id', $request->manufacturer_id);
        }
        if ($request->filled('invoice_id')){
            $purchases->where('challan_id', $request->invoice_id);
        }

        return view('pharmacy.purchase.index',[
            'purchases' => $purchases->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $challan_id = ProductPurchase::where('date', date('Y-m-d'))->value('challan_id');
        return view('pharmacy.purchase.create', [
            'challan_id' => $challan_id ? $challan_id += 1 : $challan_id = date('Ymd') . 1,
            'manufacturers' => Manufacturer::where('company_id', company_id())->pluck('name', 'id')
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
            return redirect()->route('product.purchases.show', $purchase->id)
                ->withSuccess('Purchased Successfully!');
        }
        return back()->withErrors('Quantity Not added into any products');
    }

    /**
     * Display the specified resource.
     *
     * @param ProductPurchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(ProductPurchase $purchase)
    {
        return view('pharmacy.purchase.show', [
            'productPurchase' => $purchase,
            'company' => auth()->user()->companyInfo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\ProductPurchase  $productPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPurchase $productPurchase)
    {
        return view('pharmacy.purchase.edit', [
            'inventoryProductPurchase' => $productPurchase,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory\ProductPurchase  $productPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductPurchase $productPurchase)
    {
        $request->approve($productPurchase);
        return redirect()->route('product.purchases.index')->withSuccess('Purchase Approved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory\ProductPurchase  $productPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPurchase $purchase)
    {
        $purchase->delete();
        return response([
            'check' => true
        ]);
    }


    public function purchasableProducts(Request $request)
    {
        return view('pharmacy.purchase.ajax.products', [
            'products' => Product::where('company_id', company_id())
                ->where('manufacturer_id', $request->id)
                ->get()
        ]);
    }

    public function productDelete(InventoryProductPurchaseItem $item)
    {
        $item->delete();
        return 'Product deleted successfully!';
    }

    public function productCodes(Request $request, Product $product)
    {
        $productCodes =  ProductCode::where('company_id', company_id())
            ->where('product_id', $product->id)
            ->where('name', 'LIKE', "%{$request->name}%")
            ->get(['id', 'name', 'quantity']);
        return response($productCodes, 200);
    }
}
