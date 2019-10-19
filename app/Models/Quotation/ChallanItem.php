<?php

namespace App\Models\Quotation;

use App\Models\Inventory\ProductCode;
use Illuminate\Database\Eloquent\Model;

class ChallanItem extends Model
{
    protected $fillable = [
        'challan_id', 'quotation_item_id', 'product_code_id', 'quantity'
    ];

    public function productCode()
    {
        return $this->belongsTo(ProductCode::class, 'product_code_id');
    }

    public function quotationItem()
    {
        return $this->belongsTo(QuotationItem::class, 'quotation_item_id');
    }

    public function challan()
    {
        return $this->belongsTo(Challan::class);
    }

    public function getQuantityWiseCostAttribute()
    {
        return $this->quantity * $this->quotationItem->amount;
    }

}
