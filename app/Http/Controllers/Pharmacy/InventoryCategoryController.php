<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\InventoryCategory;
use Illuminate\Http\Request;

class InventoryCategoryController extends Controller
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
        $categories = InventoryCategory::orderBy('id','desc')->where('company_id',\Auth::user()->fk_company_id)->paginate();
        return view('pharmacy.inventory.categories.index', compact('categories'));
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
        InventoryCategory::create($request->all());
        return back()->withSuccess('Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryCategory  $inventoryCategory
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryCategory $inventoryCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryCategory  $inventoryCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryCategory $inventoryCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryCategory  $inventoryCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryCategory $inventoryCategory)
    {
        $inventoryCategory->update($request->all());
        return back()->withSuccess('Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryCategory  $inventoryCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryCategory $inventoryCategory)
    {
        $inventoryCategory->delete();
        return response([
            'check' => true
        ]);
    }
}
