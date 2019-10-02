<?php

namespace App\Http\Controllers;

use App\Models\AccountSetting;
use App\Models\PettyCashDeposit;
use App\Models\PettyCashVoucher;
use App\Models\PettyCashTransaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PettyCashDepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:petty-cash-deposit-list')->only('index');
        $this->middleware('can:petty-cash-deposit-create')->only('store', 'create');
        $this->middleware('can:petty-cash-deposit-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('generalAccount.petty-cash.deposit', [
            'deposits' => PettyCashDeposit::with('depositTransaction.account', 'createdBy', 'receivedBy')->orderByDesc('id')->where('company_id', company_id())->paginate(25),
            'accounts' => AccountSetting::where([['status', 1],['fk_company_id', company_id()]])->get(),
            'expense' => PettyCashTransaction::where('company_id', company_id())
                                            ->where('transactionable_type', [PettyCashVoucher::class])->sum('amount'),
            'users' => User::query()->where('name', '!=', 'System Admin')->where('fk_company_id', company_id())->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'date' => 'required',
            'received_by' => 'required',
            'amount' => 'required',
            'account_id' => 'required'
        ]);
        DB::transaction(function () use ($request){
            $pettyCashDeposit = PettyCashDeposit::create($request->all());
            $pettyCashDeposit->expanseFromTransaction()->create([
                'account_id' => $request->account_id,
                'amount' => -$request->amount,
            ]);
            $pettyCashDeposit->pettyCashTransaction()->create([
                'amount' => $request->amount,
            ]);
        });
        return back()->withSuccess('Petty Cash Deposited Successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PettyCashDeposit  $pettyCashDeposit
     * @return \Illuminate\Http\Response
     */
    public function show(PettyCashDeposit $pettyCashDeposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PettyCashDeposit  $pettyCashDeposit
     * @return \Illuminate\Http\Response
     */
    public function edit(PettyCashDeposit $pettyCashDeposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PettyCashDeposit  $pettyCashDeposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PettyCashDeposit $pettyCashDeposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PettyCashDeposit  $pettyCashDeposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(PettyCashDeposit $pettyCashDeposit)
    {
        $pettyCashDeposit->delete();
        return response([
            'check' => true
        ]);
    }
}
