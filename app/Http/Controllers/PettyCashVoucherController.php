<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\PettyCashDeposit;
use App\Models\PettyCashVoucher;
use App\Models\PettyCashTransaction;
use Illuminate\Http\Request;
use DB;

class PettyCashVoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:petty-cash-voucher-list')->only('index');
        $this->middleware('can:petty-cash-voucher-create')->only('store', 'create');
        $this->middleware('can:petty-cash-voucher-show')->only('show');
        $this->middleware('can:petty-cash-deposit-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('generalAccount.petty-cash.voucher.index', [
            'pettyCashVouchers' => PettyCashVoucher::where('company_id', company_id())->paginate(25)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deposit = PettyCashTransaction::where('company_id', company_id())
                                    ->whereIn('transactionable_type', [PettyCashDeposit::class])->sum('amount');
        $expanse = PettyCashTransaction::where('company_id', company_id())
                                    ->whereIn('transactionable_type', [PettyCashVoucher::class])->sum('amount');

        return view('generalAccount.petty-cash.voucher.create', [
            'departments' => Department::where('company_id', company_id())->get(),
            'available_amount' => $deposit < $expanse ? false : $deposit - $expanse
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'chart_of_accounts.*' => 'required',
            'date' => 'required',
            'description.*' => 'required',
            'amount.*' => 'required',
            'totalAmount' => 'max:'.(int)$request->available_amount,
        ]);

        $pettyCashVoucher = DB::transaction(function () use($request) {
            $pettyCashVoucher = PettyCashVoucher::create([
                'date' => $request->date,
                'amount' => $request->totalAmount,
            ]);
            foreach ($request->petty_cash_charts_id as $key => $charts){
                $pettyCashVoucher->charts()->create([
                    'petty_cash_charts_id' => $charts,
                    'description' => $request->description[$key],
                    'amount' => $request->amount[$key],
                ]);

            }
            $pettyCashVoucher->pettyCashTransaction()->create([
                'amount' => $request->totalAmount,
            ]);
            return $pettyCashVoucher;
        });
        return redirect()->route('petty-cash-vouchers.show', $pettyCashVoucher->id)->withSuccess('Petty Cash Voucher Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PettyCashVoucher  $pettyCashVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(PettyCashVoucher $pettyCashVoucher)
    {
        return view('generalAccount.petty-cash.voucher.show', [
            'pettyCashVoucher' => $pettyCashVoucher->load('charts.pettyCashCharts')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PettyCashVoucher  $pettyCashVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(PettyCashVoucher $pettyCashVoucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PettyCashVoucher  $pettyCashVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PettyCashVoucher $pettyCashVoucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PettyCashVoucher  $pettyCashVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(PettyCashVoucher $pettyCashVoucher)
    {
        $pettyCashVoucher->delete();
        return response([
            'check' => true
        ]);
    }
}
