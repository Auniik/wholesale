<?php

namespace App\Models\Accounts;

use App\Models\PaymentSector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Arr;

class VoucherSector extends Model
{
    public static function boot() {
        parent::boot();

        static::deleting(function($model) {
            foreach ($model->sectorPayments as $sectorPayment){
                $sectorPayment->delete();
                $sectorPayment->payments->each->delete();
            }
        });
    }
    protected $fillable = [
        'voucher_id', 'description', 'sector_id', 'amount', 'method_id', 'account_id'
    ];

    public function chart_of_account()
    {
        return $this->belongsTo(PaymentSector::class, 'sector_id', 'id');
    }

    public function paidAmount()
    {
        return $this->hasOne(VoucherSectorPayment::class,'sector_id')
            ->selectRaw('voucher_sector_payments.sector_id, sum(transactions.amount) as amount')
            ->join('transactions', function (JoinClause $joinClause){
                $joinClause->on('voucher_sector_payments.id', '=', 'transactions.transactionable_id')
                ->where('transactions.transactionable_type', VoucherSectorPayment::class);
            })->groupBy('voucher_sector_payments.sector_id');
    }

    public function getPaidAttribute()
    {
        return Arr::get($this->paidAmount, 'amount', 0);
    }

    public function getPaymentDueAttribute()
    {
        return $this->amount + $this->paid;
    }
    public function getIncomeDueAttribute()
    {
        return $this->amount - $this->paid;
    }

    public function getDueAttribute()
    {
        return $this->amount - abs($this->paid);
    }

    public function sectorPayment()
    {
        return $this->hasOne(VoucherSectorPayment::class,'sector_id');
    }
    public function sectorPayments()
    {
        return $this->hasMany(VoucherSectorPayment::class,'sector_id');
    }
}
