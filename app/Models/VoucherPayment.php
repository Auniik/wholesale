<?php

namespace App\Models;

use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherSectorPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Arr;

class VoucherPayment extends Model
{
    protected $fillable = [
        'account_id', 'method_id', 'voucher_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function (VoucherPayment $payment){
            $payment->sectors->each->delete();
        });
    }

    public function method()
    {
        return $this->belongsTo(AccountPaymentMethod::class, 'method_id');
    }
    public function account()
    {
        return $this->belongsTo(AccountSetting::class, 'account_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function sectors()
    {
        return $this->hasMany(VoucherSectorPayment::class);
    }

    public function payments()
    {
        return $this->hasMany(VoucherSectorPayment::class, 'voucher_payment_id')
            ->join('transactions', function (JoinClause $clause){
                $clause->on('voucher_sector_payments.id', '=', 'transactions.transactionable_id')
                    ->where('transactions.transactionable_type', VoucherSectorPayment::class);
            });
    }

    public function payment()
    {
        return $this->hasOne(VoucherSectorPayment::class, 'voucher_payment_id')
            ->selectRaw('sum(amount) as amount, voucher_sector_payments.voucher_payment_id')
            ->join('transactions', function (JoinClause $clause){
                $clause->on('voucher_sector_payments.id', '=', 'transactions.transactionable_id')
                    ->where('transactions.transactionable_type', VoucherSectorPayment::class);
            })->groupBy('voucher_sector_payments.voucher_payment_id');
    }

    public function getPaidAttribute()
    {
        return abs(Arr::get($this->payment, 'amount', 0));
    }
}
