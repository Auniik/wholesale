<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryProductSaleItem extends Model
{
    protected $fillable = [
        'inventory_product_sale_id', 'product_id', 'sales_qty', 'sales_price', 'item_price'
    ];

    public function invoice()
    {
        return $this->belongsTo(InventoryProductSale::class, 'inventory_product_sale_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(InventoryProduct::class, 'product_id', 'id');
    }
}
