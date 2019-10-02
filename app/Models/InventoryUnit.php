<?php

namespace App\Models;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class InventoryUnit extends Model
{
    use AddingCompany;
    protected $fillable = ['name', 'type', 'status', 'created_by', 'updated_by', 'company_id'];
}