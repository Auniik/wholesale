<?php

namespace App\Models\Inventory;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ProductPurchaseItem extends Model
{

    protected $fillable = [
        'product_purchase_id', 'product_code_id', 'product_id', 'quantity',
        'unit_price', 'sales_price', 'expiry_date'
    ];

    protected $dates = ['expiry_date'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productCode()
    {
        return $this->belongsTo(ProductCode::class, 'product_code_id');
    }

    public function getPriceAttribute()
    {
        return $this->quantity * $this->unit_tp;
    }
}
