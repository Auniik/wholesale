<?php

namespace App\Models;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class PettyCashCharts extends Model
{
    use AddingCompany;
    protected $fillable = [
        'name', 'status', 'company_id', 'created_by', 'updated_by'
    ];
}
