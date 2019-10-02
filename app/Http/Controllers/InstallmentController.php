<?php

namespace App\Http\Controllers;

use App\Models\Accounts\Voucher;
use App\Models\Installment;
use App\Models\Party;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InstallmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:installments-list')->only('index');
        $this->middleware('can:installments-show')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $installments = Installment::query()
            ->selectRaw('payment_type, vouchers.amount as voucherTotal,
                vouchers.id as voucherId, parties.name, party_id')
            ->where('installments.company_id', company_id())
            ->orderByDesc('installments.date')
            ->join('vouchers', function (JoinClause $joinClause){
                $joinClause->on('vouchers.id', '=', 'installments.installmentable_id')
                    ->where('installments.installmentable_type', Voucher::class)
                    ->where('vouchers.approved_at', '<>', null );
            })
//            ->join('voucher_sectors', 'voucher_sectors.voucher_id', '=', 'vouchers.id')
            ->join('parties', function (JoinClause $joinClause) {
                $joinClause->on('parties.id', '=', 'vouchers.party_id');
            })
            ->groupBy('vouchers.id');



        if ($request->filled('sector_id')){
            $installments->join('voucher_sectors', 'voucher_sectors.voucher_id', '=', 'vouchers.id')
                ->selectRaw('voucher_sectors.sector_id')
                ->where('voucher_sectors.sector_id', $request->sector_id)
                ->groupBy('voucher_sectors.sector_id');
        }


        if ($request->filled('party_id')){
            $installments->where('party_id', $request->party_id);
        }
        if ($request->filled('voucher_id')){
            $installments->where('vouchers.id', $request->voucher_id);
        }
        if ($request->filled('payment_type')){
            $installments->where('payment_type', $request->payment_type);
        }


        return view('generalAccount.installments.vouchers',[
            'installments' => $installments->paginate(),

            'parties' => Party::where('company_id', company_id())->pluck('name', 'id')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Installment $installment
     * @return void
     */
    public function show(Voucher $installment)
    {
        $voucher = $installment->load('installments');
        return view('generalAccount.installments.index',[
            'voucher' => $voucher,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Installment  $installment
     * @return Response
     */
    public function edit(Installment $installment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Installment  $installment
     * @return Response
     */
    public function update(Request $request, Installment $installment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Installment  $installment
     * @return Response
     */
    public function destroy(Installment $installment)
    {
        //
    }
}
