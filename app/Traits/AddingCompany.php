<?php

namespace App\Traits;

use App\User;

trait AddingCompany
{
    public static function boot()
    {
        parent::boot();

        if (!app()->runningInConsole()){
            static::creating(function ($model){
                /** @var User $user */
                $user = auth()->user();
                $model->fill([
                    'company_id' => $user->fk_company_id,
                    'created_by' => $user->id
                ]);
            });

            static::updating(function ($model){
                $model->fill([
                    'updated_by' => auth()->id()
                ]);
            });
        }

    }
}
