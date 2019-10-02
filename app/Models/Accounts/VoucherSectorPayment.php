<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class VoucherSectorPayment extends Model
{
    protected $fillable = [
        'sector_id', 'voucher_id', 'method_id', 'account_id', 'paid_amount', 'voucher_payment_id'
    ];

    public function payments()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function sector()
    {
        return $this->belongsTo(VoucherSector::class);
    }

    public function payment()
    {
        return $this->morphOne(Transaction::class, 'transactionable')
            ->selectRaw('sum(amount) as amount, transactionable_id')
            ->groupBy('transactionable_id');
    }
}
