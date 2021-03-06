<?php

namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotation\QuotationRequest;
use App\Models\Quotation\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Quotation $quotation
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quotation.index', [
            'quotations' => Quotation::where('company_id', company_id())
                ->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quotation.create', [
            'invoice_id' => Quotation::latest()->value('invoice_id')
                ? Quotation::latest()->value('invoice_id')
                : 1000
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequest $request)
    {
        $invoice = $request->persist();
        return redirect()->route('quotations.show', $invoice->id)
            ->withSuccess('Quotation Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        return view('quotation.show', compact('quotation'), [
            'company' => auth()->user()->companyInfo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        return view('quotation.edit', compact('quotation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationRequest $request, Quotation $quotation)
    {
        $invoice = $request->update($quotation);
        return redirect()->route('quotations.show', $invoice->id)
            ->withSuccess('Quotation Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
//        DB::transaction(function ()use($quotation){
            $quotation->delete();
//        });

        return response([
            'check' => true
        ]);
    }

    /**
     * @param Quotation $quotation
     * @return string
     */
    public function invoice(Quotation $quotation)
    {
        return view('quotation.invoice', [
            'company' => auth()->user()->companyInfo,
            'quotation' => $quotation
        ]);
    }

    public function invoices()
    {
        return view('quotation.invoices', [
            'company' => auth()->user()->companyInfo,
            'quotations' => Quotation::whereHas('challans', function ($query){
                return $query;
            })
            ->where('company_id', company_id())->paginate()
        ]);
    }
}
