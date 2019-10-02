<?php

namespace App\Models\Accounts;

use App\Models\AccountSetting;
use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use AddingCompany;
    protected $fillable = [
        'company_id', 'account_id', 'amount', 'created_by'
    ];

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function account()
    {
        return $this->belongsTo(AccountSetting::class, 'account_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
