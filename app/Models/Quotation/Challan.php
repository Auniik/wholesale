<?php

namespace App\Models\Quotation;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class Challan extends Model
{
    use AddingCompany;
    protected $fillable = [
        'company_id', 'quotation_id', 'party_id', 'created_by', 'updated_by', 'shipping_address',
        'date', 'invoice_id', 'transport_mode',
    ];

    public function items()
    {
        return $this->hasMany(ChallanItem::class, 'challan_id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }
}
