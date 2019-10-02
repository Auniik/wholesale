<?php

namespace App\Http\Controllers;
use App\Http\Requests\Voucher\CreditVoucherRequest;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherSectorPayment;
use App\Models\AccountSetting;
use App\Models\Party;
use Illuminate\Http\Request;
use DB;

class GeneralIncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:credit-voucher-list')->only('index');
        $this->middleware('can:credit-voucher-create')->only('store', 'create');
        $this->middleware('can:credit-voucher-show')->only('show');
        $this->middleware('can:credit-voucher-update')->only('update', 'edit');
        $this->middleware('can:credit-voucher-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vouchers = Voucher::with('party','paidAmount', 'sectors.chart_of_account', 'sectorPayments')
            ->where([
                ['company_id', company_id()],
                ['type', 'credit']
            ]);

        if ($request->filled('sector_id')){
            $vouchers->whereHas('sectors', function ($query)use($request){
                $query->where('sector_id', $request->sector_id);
            });
        }

        if ($request->filled('party_id')){
            $vouchers->where('party_id',$request->party_id);
        }
        if ($request->filled('voucher_id')){
            $vouchers->where('id',$request->voucher_id);
        }

        return view('generalAccount.credit_voucher.index',[
            'vouchers' => $vouchers->paginate(),
            'parties' => Party::where('company_id', company_id())->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('generalAccount.credit_voucher.create',[
            'accounts' => AccountSetting::where([['fk_company_id', company_id()],['status',1]])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreditVoucherRequest $request)
    {
        $voucher = $request->persist();
        return redirect()->route('credit-vouchers.show', $voucher->id)->withSuccess('Credit voucher created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param Voucher $credit_voucher
     * @return void
     */
    public function show(Voucher $credit_voucher)
    {
        $credit_voucher->load('sectors.paidAmount', 'sectors.chart_of_account', 'paidAmount');
        return view('generalAccount.credit_voucher.show', [
            'credit_voucher' => $credit_voucher
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Voucher $credit_voucher
     * @return void
     */
    public function edit(Voucher $credit_voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Voucher $credit_voucher
     * @return void
     */
    public function update(Request $request, Voucher $credit_voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Voucher $credit_voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $credit_voucher)
    {
        $credit_voucher->delete();
        return response([
            'check' => true
        ]);
    }
}
