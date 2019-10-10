<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\ProductCode;
use Illuminate\Http\Request;

class ProductCodeController extends Controller
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
        $codes = ProductCode::orderBy('id', 'DESC')
            ->where('company_id', company_id())
            ->paginate();

        return view('pharmacy.inventory.code.index', compact('codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|max:192|unique:product_codes',
            'product_id' => 'required'
        ]);
        ProductCode::create($request->all());
        return back()->withSuccess('Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory\ProductCode  $productCode
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCode $code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProductCode $code
     * @return void
     */
    public function edit(ProductCode $code)
    {
        return view('pharmacy.inventory.code.edit', compact('code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ProductCode $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCode $code)
    {
        $request->validate([
            'name' => "required|max:192|unique:product_codes,name,{$code->id}",
            'product_id' => 'required'
        ]);
        $code->update($request->only('name', 'product_id'));
        return back()->withSuccess('Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory\ProductCode  $productCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCode $code)
    {
        $code->delete();
        return response([
            'check' => true
        ]);
    }
}
