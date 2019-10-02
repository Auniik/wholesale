<?php

namespace App\Models;

use App\Models\Accounts\Transaction;
use App\Models\Accounts\VoucherSectorPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Auth;

class AccountDashboard extends Model
{



    public function dailyMonthlyAccountStatus($type, $daily = true, $company_id)
    {
        $transaction = Transaction::where('company_id', $company_id)
                                    ->whereIn('transactionable_type', $this->transactionableTypes($type));

        if ($daily){
            return $transaction->whereDate('created_at', date('Y-m-d'))
                ->sum('amount');
        }else{
            return $transaction->whereMonth('created_at', date('n'))
                ->whereYear('created_at', date('Y'))
                ->sum('amount');
        }
    }

    public function getAmountsAttribute()
    {
        return Transaction::query()
            ->selectRaw('sum(amount) as amount, account_id')
            ->with('account')
            ->where('company_id', company_id())
            ->groupBy('account_id')
            ->get();
    }

    public function transactionableTypes($type = 'expense')
    {
        if ($type == 'income'){
            return [
                InventoryProductSale::class
            ];
        }else{
            return [
                PettyCashDeposit::class,
                InventoryProductPurchase::class
            ];
        }
    }


    public function voucherTransaction($company_id)
    {
        return Transaction::query()
            ->where('transactions.company_id', $company_id)
            ->selectRaw('sum(transactions.amount) as amount, vouchers.type')
            ->join('voucher_sector_payments', function (JoinClause $join){
                $join->on('transactions.transactionable_id', '=', 'voucher_sector_payments.id')
                    ->where('transactions.transactionable_type', VoucherSectorPayment::class);
            })->join('vouchers', function (JoinClause $joinClause)use($company_id){
                $joinClause->on('voucher_sector_payments.voucher_id','=', 'vouchers.id')
                    ->where('vouchers.company_id', $company_id);
            })
            ->groupBy('vouchers.type');
    }

    public function getGrossIncome($model, $table = Transaction::class)
    {
        return $table::where('company_id', company_id())
            ->where('transactionable_type', $model)
            ->sum('amount');
    }


    public function getAdvancePaymentAmountAttribute()
    {
        return Transaction::query()
            ->selectRaw('sum(transactions.amount) as amount')
            ->join('voucher_sector_payments', function (JoinClause $join){
                $join->on('transactions.transactionable_id', '=', 'voucher_sector_payments.id')
                    ->where('transactions.transactionable_type', VoucherSectorPayment::class);
            })
            ->join('vouchers', function (JoinClause $joinClause){
                $joinClause->on('voucher_sector_payments.voucher_id','=', 'vouchers.id')
                    ->where('vouchers.company_id', company_id())
                    ->where('vouchers.type', 'debit')
                    ->where('vouchers.payment_type', 'advance');
            })
            ->first();
    }

}
