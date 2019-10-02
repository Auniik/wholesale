<?php

namespace App\Models;

use App\Models\PettyCashTransaction;
use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;

class PettyCashVoucher extends Model
{
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            /** @var User $user */
            $user = auth()->user();
            $model->fill([
                'company_id' => $user->fk_company_id,
                'created_by' => $user->id
            ]);
        });
        static::deleting(function ($model){
            $model->charts->each->delete();
            $model->pettyCashTransaction->each->delete();
        });
    }
    protected $fillable = [
        'amount', 'date', 'created_by', 'company_id'
    ];
    protected $dates = ['date'];

    public function charts()
    {
        return $this->hasMany(PettyCashVoucherItems::class);
    }
    public function pettyCashTransaction()
    {
        return $this->morphMany(PettyCashTransaction::class, 'transactionable');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function chartsNames()
    {
        $this->charts->map(function ($chart, $key){
            echo $chart->pettyCashCharts->name ?? '';
            if (count($this->charts) - 1 > $key) echo ', ';
        });
    }
}
