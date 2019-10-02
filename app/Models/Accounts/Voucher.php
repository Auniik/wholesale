<?php

namespace App\Models\Accounts;
use App\Models\Employee;
use App\Models\Installment;
use Illuminate\Support\HtmlString;
use App\Models\AccountSetting;
use App\Models\Party;
use App\Models\VoucherInstallment;
use App\Models\VoucherPayment;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Voucher extends Model
{
    public static function boot() {
        parent::boot();

        static::creating(function ($model){
            /** @var User $user */
            $user = auth()->user();

            $model->fill([
                'company_id' => $user->fk_company_id,
                'created_by' => $user->id
            ]);
        });

        static::deleting(function($model) {
            $model->sectorPayments->each->delete();
            $model->sectors->each->delete();
            $model->installments ? $model->installments->each->delete(): false;
            foreach ($model->sectorPayments as $sectorPayment){
                $sectorPayment->payments->each->delete();
            }
        });
    }


    protected $fillable = [
        'id', 'party_id', 'company_id', 'amount', 'type', 'ref_id', 'date',
        'approved_at', 'approved_by', 'created_by', 'confirmed_by', 'confirmed_at',
        'cheque_no', 'payment_type'
    ];
    protected $dates = ['date'];

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($date));
    }

    public function sectors()
    {
        return $this->hasMany(VoucherSector::class, 'voucher_id');
    }

    public function sectorPayments()
    {
        return $this->hasMany(VoucherSectorPayment::class, 'voucher_id');
    }

    public function paidAmount()
    {
        return $this->hasOne(VoucherSectorPayment::class)
            ->selectRaw('sum(transactions.amount) as amount, voucher_sector_payments.voucher_id')
            ->join('transactions', 'transactions.transactionable_id', '=', 'voucher_sector_payments.id')
            ->where('transactions.transactionable_type', VoucherSectorPayment::class)
            ->groupBy('voucher_sector_payments.voucher_id');
    }

    public function paid()
    {
        return Arr::get($this->paidAmount, 'amount', 0);
    }

    public function due()
    {
        return ($this->amount - abs($this->paid()));
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function isDebit()
    {
        return $this->type == 'debit';
    }
    public function isPaymentType($type)
    {
        return $this->payment_type == $type;
    }
    public function payments()
    {
        return $this->hasMany(VoucherPayment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
    public function approvedByEmployee()
    {
        return $this->belongsTo(Employee::class, 'approved_by', 'user_id');
    }

    public function chartsNames()
    {
         $this->sectors->map(function ($chart, $key){
            echo optional($chart->chart_of_account)->sector_name;
            if (count($this->sectors) - 1 > $key) echo ', ';
        });
    }
    public function installments()
    {
        return $this->morphMany(Installment::class, 'installmentable')->orderBy('purpose', 'asc');
    }

    public function approved() : bool
    {
        return $this->approved_at && $this->confirmed_at;
    }


}
