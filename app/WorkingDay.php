<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    protected $fillable = [
        'month',
        'year',
        'work_day',
        'updated_by',
        'company',
        'brunch'
    ];
}
