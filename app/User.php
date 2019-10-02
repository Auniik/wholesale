<?php

namespace App;

use App\Models\CompanyList;
use App\Models\Employee;

use App\Models\IndoorDueReceive;
use App\Models\OutdoorPayment;
use App\Models\Role;
use App\Models\ServiceSalesDueReceive;
use App\Traits\AddingCompany;
use App\Traits\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use AddingCompany;
    protected $fillable = [
        'name', 'email', 'password','type','status','phone_number','address',
        'fk_company_id', 'branch_id', 'created_by', 'role_id', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function scopeCompany($query)
    {
        $query->where('fk_company_id',auth()->user()->fk_company_id)->orderBy('id','desc');
    }

    public function companyInfo()
    {
        return $this->belongsTo(CompanyList::class,'fk_company_id','id');
    }


    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function photo()
    {
//        return
    }
}
