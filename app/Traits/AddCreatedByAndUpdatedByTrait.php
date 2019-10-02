<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 2/19/19
 * Time: 3:21 PM
 */

namespace App\Traits;


use function foo\func;

trait AddCreatedByAndUpdatedByTrait
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = auth()->user();
            $model->fill([
                'created_by' => $user->id,
                'updated_by' => $user->id
            ]);
        });

        static::updating(function ($model) {
            $model->fill([
                'updated_by' => auth()->id()
            ]);
        });
    }
}