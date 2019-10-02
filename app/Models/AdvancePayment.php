<?php

namespace App\Models;

use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;

class AdvancePayment extends Model
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            /** @var User $user */
            $user = auth()->user();
            $model->fill([
                'company_id' => $user->fk_company_id,
            ]);
        });

    }


    protected $fillable = [
        'company_id', 'voucher_id', 'status'
    ];
}
