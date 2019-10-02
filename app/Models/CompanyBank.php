<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBank extends Model
{
    protected $table = 'company_banks';
    protected $fillable = [
        'company_id','bank_name','account_name','branch_name','SWIFT','routing_number','created_by',
        'updated_by', 'opening_balance'
    ];
}
