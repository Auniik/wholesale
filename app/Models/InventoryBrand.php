<?php

namespace App\Models;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class InventoryBrand extends Model
{
    use AddingCompany;
    protected $fillable = ['name', 'status', 'created_by', 'updated_by', 'company_id'];
}
