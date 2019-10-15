<?php

namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotation\ChallanRequest;
use App\Models\Quotation\Challan;
use App\Models\Quotation\Quotation;
use Illuminate\Http\Request;

class ChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quotation.challan.index', [
            'challans' => Challan::where('company_id', company_id())->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Quotation $quotation
     * @return \Illuminate\Http\Response
     */
    public function create(Quotation $quotation)
    {
        $challan_id = Challan::where('date', date('Y-m-d'))->value('invoice_id');
        $challan_id ? $challan_id += 1 : $challan_id = date('ymd') . 1;

        return view('quotation.challan.create', [
            'quotation' => $quotation,
            'challan_id' => $challan_id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChallanRequest $request)
    {
        $challan = $request->persist();
        return redirect()->route('challans.show', [$challan->quotation->id, $challan])
            ->withSuccess('Challan Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation\Challan  $challan
     * @return \Illuminate\Http\Response
     */
    public function show(Challan $challan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation\Challan  $challan
     * @return \Illuminate\Http\Response
     */
    public function edit(Challan $challan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation\Challan  $challan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challan $challan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation\Challan  $challan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challan $challan)
    {
        //
    }
}
