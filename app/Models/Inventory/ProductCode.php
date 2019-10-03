<?php

namespace App\Models\Inventory;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class ProductCode extends Model
{
    use AddingCompany;
    protected $fillable = [
        'name', 'created_by', 'updated_by', 'company_id'
    ];
}
