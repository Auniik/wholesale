<?php

namespace App\Models;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class SmsConfig extends Model
{
    use AddingCompany;

    protected $table = 'sms_configs';

    protected $fillable = [
        'masking_name', 'user_name', 'user_password', 'sms_quantity', 'company_id', 'created_by', 'updated_by'
    ];

    public function company()
    {
        return $this->belongsTo(CompanyList::class, 'company_id');
    }
}
