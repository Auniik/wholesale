<?php

namespace App\Models\Inventory;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use AddingCompany;
    protected $fillable = [
        'name', 'status', 'created_by', 'updated_by', 'company_id']
    ;
}
