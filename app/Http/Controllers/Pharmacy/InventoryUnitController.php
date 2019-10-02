<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\InventoryUnit;
use Illuminate\Http\Request;

class InventoryUnitController extends Controller
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
        $units = InventoryUnit::orderBy('id','desc')->where('company_id',company_id())->paginate();
        return view('pharmacy.inventory.unit.index', compact('units'));
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
        InventoryUnit::create($request->all());
        return back()->withSuccess('Unit Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryUnit  $inventoryUnit
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryUnit $inventoryUnit)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryUnit  $inventoryUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryUnit $inventoryUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryUnit  $inventoryUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryUnit $inventoryUnit)
    {
        $inventoryUnit->update($request->all());
        return back()->withSuccess('Unit updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryUnit  $inventoryUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryUnit $inventoryUnit)
    {
        $inventoryUnit->delete();
        return back()->withSuccess('Unit Deleted');
    }
}
