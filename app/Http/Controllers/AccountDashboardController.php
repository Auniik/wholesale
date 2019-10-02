<?php

namespace App\Http\Controllers;

use App\Http\Resources\Dashboard\AccountDashboardResource;
use App\Http\Resources\Dashboard\GrossVoucherTransaction;
use App\Http\Resources\Dashboard\TotalVoucherAmount;
use App\Models\AccountDashboard;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherSectorPayment;
use App\Models\DoctorAppointment;
use App\Models\HospitalServiceSale;
use App\Models\IndoorPatientBooking;
use App\Models\PettyCashDeposit;
use App\Models\PettyCashVoucher;
use App\Models\PettyCashTransaction;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class AccountDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AccountDashboard $dashboard
     * @return \Illuminate\Http\Response
     */
    public function index(AccountDashboard $dashboard)
    {
        $voucherTransaction = $dashboard->voucherTransaction(company_id());


        $monthlyVoucher = clone $voucherTransaction;
        $todayVoucher = clone $voucherTransaction;

        $todayVoucher->whereDate('transactions.created_at', date('Y-m-d'));
        $monthlyVoucher->whereMonth('transactions.created_at', date('n'))
            ->whereYear('transactions.created_at', date('Y'));

//        $grossAppointmentAmount = DoctorAppointment::where('company_id', company_id())->sum('doctor_fee');
//        $grossAppointmentIncome = $dashboard->getGrossIncome(DoctorAppointment::class);


//        $grossServiceAmount = HospitalServiceSale::where('company_id', company_id())
//            ->get()
//            ->sum(function ($service){
//                return $service->subtotal - $service->discount;
//        });
//
//        $grossServiceIncome = $dashboard->getGrossIncome(HospitalServiceSale::class);
//
//        $grossIndoorAmount = IndoorPatientBooking::where('company_id', company_id())
//            ->get()
//            ->sum(function ($booking){
//                return $booking->totalPrice;
//        });

//        $grossIndoorIncome = $dashboard->getGrossIncome(IndoorPatientBooking::class);

        $pettyCashDeposit = $dashboard->getGrossIncome(PettyCashDeposit::class, PettyCashTransaction::class);

        $pettyCashExpense = $dashboard->getGrossIncome(PettyCashVoucher::class, PettyCashTransaction::class);

        return view('generalAccount.dashboard.index', [

            'today_transaction' => $todayVoucher->get()
                ->keyBy('type'),

            'monthly_transaction' => $monthlyVoucher->get()
                ->keyBy('type'),

            'amounts' => $dashboard->amounts,

            'totalAmount' => Voucher::selectRaw('sum(amount) as amount, type')
                ->where('company_id', company_id())
                ->groupBy('type')
                ->get()
                ->keyBy('type'),

            'totalPaid' => $voucherTransaction->get()
                ->keyBy('type'),


            'todayIncome' => $dashboard->dailyMonthlyAccountStatus('income', true, company_id()),

            'monthlyIncome' => $dashboard->dailyMonthlyAccountStatus('income', false, company_id()),

            'todayExpense' => $dashboard->dailyMonthlyAccountStatus('expense', true, company_id()),

            'monthlyExpense' => $dashboard->dailyMonthlyAccountStatus('expense', false, company_id()),

            'availablePettyCash' => $pettyCashDeposit - $pettyCashExpense,


            'advancePayment' => $dashboard->advancePaymentAmount,

            'grossIncomeByDay' => Transaction::whereIn('transactionable_type', $dashboard->transactionableTypes('income'))
                ->selectRaw('sum(amount) as amount, created_at')
                ->whereMonth('created_at', date('n'))
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw('Date(created_at)'))
                ->get()
                ->keyBy('created_at'),

        ]);
    }



    public function dashboard()
    {
        return AccountDashboardResource::make([]);
    }

}
