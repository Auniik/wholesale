<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;

use App\Models\Accounts\Transaction;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherSectorPayment;
use Illuminate\Database\Query\JoinClause;

class Dashboard
{
    public function installments()
    {
        return Installment::query()
            ->selectRaw('purpose, installments.date, payment_type, vouchers.amount as voucherTotal, 
                installments.amount as installmentAmount, vouchers.id as voucherId, parties.name,
                installments.id as installmentId, installments.status
            ')
            ->where('installments.company_id', company_id())
            ->where('installments.status', '<>', 'paid')
//            ->whereDate('installments.created_at', '>=', date('Y-m-d'))
            ->join('vouchers', function (JoinClause $joinClause){
                $joinClause->on('vouchers.id', '=', 'installments.installmentable_id')
                    ->where('installments.installmentable_type', Voucher::class)
                    ->where('vouchers.approved_at', '<>', null );
            })
            ->join('parties', function (JoinClause $joinClause) {
                $joinClause->on('parties.id', '=', 'vouchers.party_id');
            })
            ->get();
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
}
