<?php

namespace App\Models\Quotation;

use Illuminate\Database\Eloquent\Model;

class Challan extends Model
{
    protected $fillable = [
        'company_id', 'quotation_id', 'party_id', 'created_by', 'updated_by', 'shipping_address',
        'date', 'invoice_id'
    ];

    public function items()
    {
        return $this->hasMany(ChallanItem::class, 'challan_item_id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }
}
