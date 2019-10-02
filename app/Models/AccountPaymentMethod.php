<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountPaymentMethod extends Model
{
    protected $table = "account_payment_method";
    protected $fillable = [
        'fk_account_id', 'method_name', 'description', 'status', 'fk_company_id', 'created_by', 'updated_by'
    ];

    // relation with account
    public function getAccount(){
        return $this->belongsTo(AccountSetting::class, 'fk_account_id', 'id');
    }

}
