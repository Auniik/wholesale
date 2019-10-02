<?php

namespace App\Models;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    use AddingCompany;
    protected $fillable = [
        'outdoor_discount', 'outdoor_sms', 'indoor_discount', 'service_discount', 'company_id'
    ];
}
