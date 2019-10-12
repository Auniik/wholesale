<?php

namespace App\Models\Inventory;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class ProductCode extends Model
{
    use AddingCompany;
    protected $fillable = [
        'name', 'product_id', 'quantity', 'created_by', 'updated_by', 'company_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
