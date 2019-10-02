<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceTransfer\BalanceTransferRequest;
use App\Models\Accounts\Transaction;
use App\Models\AccountSetting;
use App\Models\BalanceTransfer;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceTransferController extends Controller
{
    use FileUploadTrait;
    public function __construct()
    {
        $this->middleware('can:balance-transfer-list')->only('index');
        $this->middleware('can:balance-transfer-create')->only('create', 'store');
        $this->middleware('can:balance-transfer-update')->only('edit', 'update');
        $this->middleware('can:balance-transfer-delete')->only('destroy');
        $this->middleware('can:balance-transfer-approve')->only('approve');
        $this->middleware('can:balance-transfer-show')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.balance-transfer.index', [
            'balanceTransfers' => BalanceTransfer::orderBy('id', 'DESC')->where('company_id', company_id())->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account.balance-transfer.create', [
            'accounts' =>  AccountSetting::where([['fk_company_id', company_id()],['status', 1]])->get()

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BalanceTransferRequest $request)
    {
        $request->store();
        return back()->withSuccess('Balance Transfer Completed Successfully');

    }

    public function approve(BalanceTransfer $balanceTransfer)
    {
        DB::transaction(function ()use($balanceTransfer){
            $balanceTransfer->update([
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);
            $balanceTransfer->transaction()->create([
                'account_id' => $balanceTransfer->transfer_from,
                'amount' => -$balanceTransfer->amount
            ]);
            $balanceTransfer->transaction()->create([
                'account_id' => $balanceTransfer->transfer_to,
                'amount' => $balanceTransfer->amount
            ]);

        });
//        return redirect()->route('balance-transfers.index')->withSuccess('Balance Transfer Approved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BalanceTransfer  $balanceTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(BalanceTransfer $balanceTransfer)
    {
        return view('account.balance-transfer.show', [
            'balanceTransfer' => $balanceTransfer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BalanceTransfer  $balanceTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(BalanceTransfer $balanceTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BalanceTransfer  $balanceTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BalanceTransfer $balanceTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BalanceTransfer  $balanceTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(BalanceTransfer $balanceTransfer)
    {
        $balanceTransfer->transaction()->delete();
        $this->deleteFile($balanceTransfer->bank_slip);
        $balanceTransfer->delete();
        return response([
            'check' => true
        ]);
    }


    public function getBalance(Request $request)
    {
        return [
            'accounts' => AccountSetting::where('fk_company_id', company_id())
                ->where([['id','!=', $request->id],['status', 1]])
                ->get(),
            'balance' => Transaction::where([['company_id', company_id()],['account_id', $request->id]])
                ->sum('amount')
        ];
    }
}
