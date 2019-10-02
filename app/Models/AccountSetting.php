<?php

namespace App\Models;

use App\AccountSelaryPay;
use App\Models\Accounts\Transaction;
use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class AccountSetting extends Model
{
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            $model->fill([
               'fk_company_id' => auth()->user()->fk_company_id,
               'created_by' => auth()->id(),
               'updated_by' => auth()->id()
            ]);
        });
        static::updating(function ($model){
            $model->fill([
                'updated_by' => auth()->id()
            ]);
        });

    }
    protected $table = "account";

    protected $fillable = [
        'account_name','opening_balance','description','status','created_by', 'updated_by','fk_company_id',
        'current_balance', 'branch_name', 'SWIFT', 'routing_number', 'account_no', 'default_status'
    ];


	public function getMethod()
    {
		return $this->hasOne(AccountPaymentMethod::class , 'fk_account_id', 'id');
	}


    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
}
