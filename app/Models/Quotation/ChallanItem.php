<?php

namespace App\Models\Quotation;

use App\Models\Inventory\Product;
use App\Models\Inventory\ProductCode;
use Illuminate\Database\Eloquent\Model;

class ChallanItem extends Model
{
    protected $fillable = [
        'challan_id', 'product_id', 'product_code_id', 'quantity'
    ];

    public function productCode()
    {
        return $this->belongsTo(ProductCode::class, 'product_code_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function inventoryUpdate($quantity)
    {
        $this->productCode->update([
            'quantity' => $this->productCode->quantity - $quantity
        ]);

        $this->product->update([
            'quantity' => $this->product->quantity - $quantity
        ]);


    }
}
