<?php

namespace App\Http\Controllers;

use App\Models\PettyCashCharts;
use Illuminate\Http\Request;

class PettyCashChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('generalAccount.petty-cash.charts', [
            'pettyCashChartOfAccounts' => PettyCashCharts::where('company_id', company_id())->orderBy('id', 'DESC')->paginate()
        ]);
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
            'name' => 'required',
            'status' => 'required'
        ]);
        PettyCashCharts::create($request->except('_token'));
        return back()->withSuccess('Petty Cash Charts Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PettyCashCharts  $pettyCashCharts
     * @return \Illuminate\Http\Response
     */
    public function show(PettyCashCharts $pettyCashCharts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PettyCashCharts  $pettyCashCharts
     * @return \Illuminate\Http\Response
     */
    public function edit(PettyCashCharts $pettyCashCharts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param PettyCashCharts $pettyCashChart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PettyCashCharts $pettyCashChart)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
        $pettyCashChart->update($request->except('_token'));
        return back()->withSuccess('Petty Cash Charts Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PettyCashCharts  $pettyCashCharts
     * @return \Illuminate\Http\Response
     */
    public function destroy(PettyCashCharts $pettyCashChart)
    {
        //
    }

    public function loadPettyCharts(Request $request)
    {
        $charts = PettyCashCharts::select('name', 'id')
                                ->where('company_id', company_id())
                                ->where('name', 'LIKE', "%{$request->query('name')}%")
                                ->get();
        return response()->json($charts);
    }
}
