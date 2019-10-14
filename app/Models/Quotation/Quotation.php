<?php

namespace App\Models\Quotation;

use App\Models\Party;
use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use AddingCompany;
    protected $fillable = [
        'party_id', 'created_by', 'company_id', 'updated_at ', 'updated_by', 'bank_id', 'validity', 'shipping_address',
        'amount', 'discount', 'invoice_id'
    ];

    protected function setValidityAttribute($date)
    {
        $this->attributes['validity'] =  $date;
    }

    protected $dates = [
        'validity'. 'created_at'
    ];

    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }

    public function challans()
    {
        return $this->hasMany(Challan::class, 'quotation_id');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDateAttributes()
    {
        return $this->created_at->format('d-m-Y');
    }

    public function getTotalAmountAttribute()
    {
        return $this->amount - $this->discount;
    }


}
