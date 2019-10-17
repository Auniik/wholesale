<?php

namespace App\Models\Quotation;

use App\Models\Inventory\Product;
use App\Models\Inventory\ProductCode;
use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use AddingCompany;
    protected $fillable = [
        'quotation_id', 'product_id', 'description', 'quantity',
        'unit_tp', 'amount', 'discount'
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getTotalAmountAttribute()
    {
        return $this->quantity * $this->amount;
    }

//    public function itemsDelivered()
//    {
//        return $this->hasMany(ChallanItemInventory::class, 'quotation_id');
//    }
//
//    public function deliveredQuantity()
//    {
//        return $this->itemsDelivered->sum('quantity');
//    }
//
//    public function getChallanableQuantityAttribute()
//    {
//        return $this->quantity - $this->itemsDelivered->sum('quantity');
//    }

    public function challanItems()
    {
        return $this->hasMany(ChallanItem::class, 'quotation_item_id');
    }
    public function getDeliveredQtyAttribute()
    {
        return $this->challanItems->sum('quantity') ?? 0;
    }

    public function getAvailableQtyAttribute()
    {
        return $this->quantity - $this->deliveredQty;
    }

}
