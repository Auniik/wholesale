<?php

namespace App\Http\Controllers;

use App\Http\Requests\Voucher\VoucherPaymentRequest;
use App\Traits\InstallmentsTrait;
use Exception;
use Illuminate\Http\Request;
use App\Models\{Accounts\Voucher,
    Accounts\VoucherSectorPayment,
    AccountSetting,
    Installment,
    VoucherPayment};
use Illuminate\Support\Facades\DB;

class VoucherPaymentController extends Controller
{

    public function index(Voucher $voucher)
    {
        $voucher = $voucher->load('payments.payment');
        return view('generalAccount.voucher.index', compact('voucher'));
    }


    public function create(Voucher $voucher)
    {
        $voucher->load('sectors.paidAmount');

        return view('generalAccount.voucher.payment', compact('voucher'), [
            'accounts' => AccountSetting::where('fk_company_id', company_id())->where('status',1)->get()
        ]);
    }

    public function store(VoucherPaymentRequest $request, Voucher $voucher)
    {
        $request->validate([
            'totalPaid' => 'required|numeric|max:' . $voucher->due()
        ]);
        $voucherPayment = $request->persist($voucher);

        return redirect()->action('VoucherPaymentController@show', $voucherPayment);
    }

    public function show(VoucherPayment $payment)
    {
//        dd($payment->payments);
        return view('generalAccount.voucher.show', compact('payment'));
    }

    /**
     * @param VoucherPayment $payment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy(VoucherPayment $payment)
    {
        $payment->delete();
        return response([
            'check' => true
        ]);
    }
}
