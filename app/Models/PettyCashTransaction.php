<?php

namespace App\Models;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class PettyCashTransaction extends Model
{
    use AddingCompany;
    protected $fillable = [
        'company_id', 'amount', 'created_by'
    ];
    public function transactionable()
    {
        return $this->morphTo();
    }
}
