<?php

namespace App\Models\Quotation;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'party_id', 'created_by', 'updated_by', 'bank_id', 'validity', 'shipping_address',
        'amount', 'discount'
    ];

    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }
    public function challans()
    {
        return $this->hasMany(Challan::class, 'quotation_id');
    }

}
