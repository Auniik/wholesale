<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryProductPurchaseItem extends Model
{
    protected $fillable = [
        'inventory_product_purchase_id', 'product_id', 'pack_size', 'quantity', 'retail_quantity',
        'unit_tp', 'retail_sales_price', 'sales_price', 'unit_vat', 'expiry_date'
    ];

    protected $dates = ['expiry_date'];

    public function product()
    {
        return $this->belongsTo(InventoryProduct::class, 'product_id');
    }

    public function getPriceAttribute()
    {
        return $this->quantity * $this->unit_tp;
    }


}
