<?php

namespace App\Models\Quotation;

use Illuminate\Database\Eloquent\Model;

class ChallanItemInventory extends Model
{
    protected $fillable = [
        'challan_id', 'quotation_id', 'challan_item_id', 'quantity'
    ];

    public function challanItem()
    {
        return $this->belongsTo(ChallanItem::class, 'challan_item_id');
    }
}
