<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimaryInfo extends Model
{
    protected $table='primary_info';

    protected $fillable=['company_name','logo','address','mobile_no','email','favicon','description','web','fb_link'];
}
