<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = "inventory_unit";
    protected $fillable = ['unit_name','status','fk_company_id'];
}
