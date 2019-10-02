<?php

namespace App\Models;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class InventoryProductBarcode extends Model
{
    use AddingCompany;
    protected $fillable = [
        'number', 'inventory_product_id', 'created_by', 'updated_by', 'company_id'
    ];

    public function product()
    {
        return $this->belongsTo(InventoryProduct::class, 'inventory_product_id');
    }

    public function getImageAttribute()
    {
        return "data:image/png;base64,".
            \DNS1D::getBarcodePNG($this->number, "C128" , 1.5, 35);
    }
}
