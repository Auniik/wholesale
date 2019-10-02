<?php

namespace App\Http\Controllers;

use App\Http\Requests\Voucher\StoreDebitVoucherRequest;
use App\Models\Accounts\Voucher;
use App\Models\AccountSetting;
use App\Models\Party;
use Illuminate\Http\Request;

class AdvancePaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:advance-voucher-list')->only('index');
        $this->middleware('can:advance-voucher-create')->only('store', 'create');
        $this->middleware('can:approve-advance-voucher')->only( 'adjust');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $vouchers = Voucher::with('party','paidAmount', 'sectors.chart_of_account', 'sectorPayments')
            ->orderBy('date', 'DESC')
            ->orderBy('approved_at', 'ASC')
            ->where([['company_id', company_id()], ['type', 'debit']])
            ->whereIn('payment_type', ['adjusted', 'advance']);
        if ($request->filled('party_id')){
            $vouchers->where('party_id',$request->party_id);
        }
        if ($request->filled('voucher_id')){
            $vouchers->where('id',$request->voucher_id);
        }
        return view('generalAccount.advance-payment.index',[
            'vouchers' => $vouchers->paginate(),
            'parties' => Party::where('company_id', company_id())->pluck('name','id')
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('generalAccount.advance-payment.create', [
            'accounts' => AccountSetting::where([['fk_company_id', company_id()],['status',1]])->get(),
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreDebitVoucherRequest $request)
    {
        $voucher = $request->store('advance');
        return redirect()->route('debit-vouchers.show', $voucher->id)->withSuccess('Advance Payment voucher created successfully!');
    }

    /**
     * @param Request $request
     * @param Voucher $voucher
     */
    public function adjust(Request $request, Voucher $voucher)
    {
        $voucher->update([
            'payment_type' => 'adjusted'
        ]);
        return redirect()->route('debit-vouchers.show', $voucher->id)->withSuccess('Advance Payment Adjusted successfully!');
    }
}
