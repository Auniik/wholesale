<?php

namespace App\Models;

use App\Models\Accounts\Transaction;
use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;

class BalanceTransfer extends Model
{
    use AddingCompany;
    protected $fillable = [
        'date', 'transfer_from', 'transfer_to', 'company_id', 'created_by', 'amount', 'description',
        'bank_slip', 'approved_at', 'approved_by'
    ];
    protected $dates = ['date'];

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function fromAccount()
    {
        return $this->belongsTo(AccountSetting::class, 'transfer_from');
    }
    public function toAccount()
    {
        return $this->belongsTo(AccountSetting::class, 'transfer_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
