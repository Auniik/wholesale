<?php

namespace App\Models;

use App\Models\Accounts\Transaction;
use App\Models\PettyCashTransaction;
use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class PettyCashDeposit extends Model
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
            $model->expanseFromTransaction->each->delete();
            $model->pettyCashTransaction->each->delete();
        });
    }
    protected $fillable = [
        'received_by', 'date', 'amount', 'created_by', 'company_id'
    ];
    protected $dates = ['date'];

    public function expanseFromTransaction()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
    public function depositTransaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function pettyCashTransaction()
    {
        return $this->morphMany(PettyCashTransaction::class, 'transactionable');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

}
