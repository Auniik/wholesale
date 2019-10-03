<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\BarcodeRequest;
use App\Models\Inventory\Barcode;
use App\Models\Inventory\Product;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $barcodes = Barcode::where('company_id', company_id());
        if ($request->filled('barcode')){
            $barcodes->where('number', $request->barcode);
        }
        if ($request->filled('product_id')){
            $barcodes->where('product_id', $request->product_id);
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
     * @param  \App\Models\Inventory\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function show(Barcode $barcode)
    {
        return view('pharmacy.inventory.barcode.show', [
            'barcode' => $barcode,
//            'generator' => new Picqer\Barcode\BarcodeGeneratorPNG(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Barcode $barcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barcode $barcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory\Barcode  $barcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barcode $barcode)
    {
        $barcode->delete();
        return response([
            'check' => true
        ]);
    }

    public function loadBarcodeableProducts(Request $request)
    {
        return Product::doesntHave('barcode')
            ->where('company_id', company_id())
            ->where('name', 'LIKE', "%{$request->query('name')}%")
            ->take(15)
            ->get();
    }

    public function getBarcodeNumber(Product $product)
    {
        return rand(1999, 99999). str_pad($product->id, '6', '0', STR_PAD_LEFT);
    }
}
