<?php

namespace App\Models;

use App\Models\Accounts\Voucher;
use App\Models\Procurement\EquipmentPurchase;
use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\HtmlString;

class Installment extends Model
{
    use AddingCompany;
    protected $fillable = [
        'company_id', 'purpose', 'date', 'amount', 'status', 'paid_date'
    ];

    protected $dates = ['date'];

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($date));
    }

    public function installmentable()
    {
        return $this->morphTo();
    }

    public function getInstallmentTypeAttribute()
    {
        if ($this->installmentable_type =='App\Models\Accounts\Voucher'){
            return 'Voucher';
        }
        if ($this->installmentable_type =='App\Models\Accounts\Purchase'){
            return 'Purchase';
        }
    }

    public function voucher()
    {
//        return $this->
    }

    public function paid() : bool
    {
        return $this->status == 'paid';
    }

    /*
     *Publication status helper;
     *
     */
    public function status(){
        if ($this->status == 'paid'){
            return new HtmlString("<span class=\"badge badge-default\"><i class='fa fa-check-circle text-success'></i> PAID</span>");
        }
        else{
            return new HtmlString("<span class=\"badge badge-default\"><i class='fa fa-times-circle text-warning'></i> PENDING</span>");
        }

    }

    public function isPaid()
    {
        return $this->status == 'paid';
    }




    public function getUnixDateAttribute()
    {
        return mktime(0,0,0, $this->date->format('m'), $this->date->format('d'), $this->date->format('Y'));
    }
}
