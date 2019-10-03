<?php

namespace App\Models\Inventory;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use AddingCompany;
    protected $fillable = [
        'number', 'product_id', 'created_by', 'updated_by', 'company_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getImageAttribute()
    {
        return "data:image/png;base64,".
            \DNS1D::getBarcodePNG($this->number, "C128" , 1.5, 35);
    }
}
