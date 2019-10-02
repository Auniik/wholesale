<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsGroup extends Model
{
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            $model->fill([
                'fk_company_id' => company_id(),
                'created_by' => auth()->id(),
            ]);
        });
        static::updating(function ($model){
            $model->fill([
                'update_by' => auth()->id(),
            ]);
        });
    }


    protected $table = 'sms_groups';
    Protected $fillable = ['group_name','numbers','fk_company_id','created_by','update_by'];

    public function scopeCompany($query)
    {
        $query->where('fk_company_id', company_id());
    }
}
