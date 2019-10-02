<?php

namespace App\Http\Controllers;

use App\Http\Requests\Voucher\ApproveDebitVoucherRequest;
use App\Http\Requests\Voucher\StoreDebitVoucherRequest;

use App\Models\Accounts\Voucher;
use App\Models\AccountSetting;
use App\Models\Party;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use PDF;

class GeneralPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:debit-voucher-list')->only('index');
        $this->middleware('can:debit-voucher-create')->only('store', 'create');
        $this->middleware('can:debit-voucher-show')->only('show');
        $this->middleware('can:debit-voucher-delete')->only('destroy');
        $this->middleware('can:approve-debit-voucher')->only('edit', 'update');
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
            ->orderBy('approved_at', 'ASC')
            ->where([
                ['vouchers.company_id', company_id()],
                ['vouchers.type', 'debit'],
                ['vouchers.payment_type', 'partial']
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


        return view('generalAccount.debit_voucher.index',[
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
        return view('generalAccount.debit_voucher.create',[
            'accounts' => AccountSetting::where([
                ['fk_company_id', company_id()],
                ['status',1]
            ])->get(),
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
        $voucher = $request->store();
        return redirect()->route('debit-vouchers.show', $voucher->id)
            ->withSuccess('Debit voucher created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param Voucher $debit_voucher
     * @return Response
     */
    public function show(Voucher $debit_voucher)
    {
        $debit_voucher->load('sectors.paidAmount', 'sectors.chart_of_account', 'paidAmount', 'party');
        return view('generalAccount.debit_voucher.show', [
            'debit_voucher' => $debit_voucher
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Voucher $debit_voucher
     * @return void
     */
    public function edit(Voucher $debit_voucher)
    {
        return view('generalAccount.debit_voucher.edit', [
            'debit_voucher' => $debit_voucher->load('sectors.chart_of_account', 'sectors.paidAmount'),
            'accounts' => AccountSetting::where([
                ['fk_company_id', company_id()],
                ['status', 1]
            ])
                ->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Voucher $debit_voucher
     * @return void
     */
    public function update(ApproveDebitVoucherRequest $request, Voucher $debit_voucher)
    {
        $voucher = $request->approve($debit_voucher);
        return redirect()->route('debit-vouchers.show', $voucher->id)->withSuccess('Voucher Approved successfully!');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param Voucher $debit_voucher
     * @return Response
     * @throws Exception
     */
    public function destroy(Voucher $debit_voucher)
    {
        $debit_voucher->delete();
        return response([
            'check' => true
        ]);
    }


    public function editConfirm(Voucher $debit_voucher)
    {
        return view('generalAccount.debit_voucher.confirm', [
            'debit_voucher' => $debit_voucher->load('sectors.chart_of_account', 'sectors.paidAmount'),
            'accounts' => AccountSetting::where([
                ['fk_company_id', company_id()],
                ['status', 1]
            ])
                ->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Voucher $debit_voucher
     * @return void
     */
    public function updateConfirm(ApproveDebitVoucherRequest $request, Voucher $debit_voucher)
    {
        $voucher = $request->approve($debit_voucher);
        return redirect()->route('debit-vouchers.show', $voucher->id)->withSuccess('Voucher Approved successfully!');
    }



}
