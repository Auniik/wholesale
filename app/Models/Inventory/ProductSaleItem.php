<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class ProductSaleItem extends Model
{
    protected $fillable = [
        'product_sale_id', 'product_id', 'product_code_id', 'quantity', 'amount', 'unit_tp'
    ];

    public function invoice()
    {
        return $this->belongsTo(ProductSale::class, 'product_sale_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productCode()
    {
        return $this->belongsTo(ProductCode::class, 'product_code_id');
    }
}
