<?php

namespace App\Models\Inventory;

use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use AddingCompany;
    protected $fillable = [
        'company_id', 'amount', 'created_by'
    ];

    public function transactionable()
    {
        return $this->morphTo();
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
