<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\BarcodeRequest;
use App\Models\InventoryProduct;
use App\Models\InventoryProductBarcode;
use Illuminate\Http\Request;
use Picqer;

class InventoryProductBarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $barcodes = InventoryProductBarcode::where('company_id', company_id());
        if ($request->filled('barcode')){
            $barcodes->where('number', $request->barcode);
        }
        if ($request->filled('product_id')){
            $barcodes->where('inventory_product_id', $request->product_id);
        }
        return view('pharmacy.inventory.barcode.index', [
            'barcodes' => $barcodes->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pharmacy.inventory.barcode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BarcodeRequest $request)
    {
        $request->persist();

        return back()->withSuccess('Barcode Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param InventoryProductBarcode $inventoryBarcode
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryProductBarcode $inventoryBarcode)
    {
        return view('pharmacy.inventory.barcode.show', [
            'barcode' => $inventoryBarcode,
//            'generator' => new Picqer\Barcode\BarcodeGeneratorPNG(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InventoryProductBarcode $inventoryBarcode
     * @return void
     */
    public function edit(InventoryProductBarcode $inventoryBarcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param InventoryProductBarcode $inventoryBarcode
     * @return void
     */
    public function update(Request $request, InventoryProductBarcode $inventoryBarcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param InventoryProductBarcode $inventoryBarcode
     * @return void
     */
    public function destroy(InventoryProductBarcode $inventoryBarcode)
    {
        $inventoryBarcode->delete();
        return response([
            'check' => true
        ]);
    }

    public function loadBarcodeableProducts(Request $request)
    {
        return InventoryProduct::doesntHave('barcode')
            ->with('unit')
            ->where('company_id', company_id())
            ->where('name', 'LIKE', "%{$request->query('name')}%")
            ->take(15)
            ->get();
    }

    public function getBarcodeNumber(InventoryProduct $product)
    {
        return rand(1999, 99999). str_pad($product->id, '6', '0', STR_PAD_LEFT);
    }
}
