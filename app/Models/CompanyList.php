<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyList extends Model
{

    protected $table='company_list';

    protected $fillable=[
        'company_name', 'logo', 'address', 'mobile_no', 'email', 'fax', 'favicon', 'web', 'status'
    ];

    public function bank()
    {
        return $this->hasMany(CompanyBank::class,'company_id','id');
    }
}
