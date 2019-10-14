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

    public function geTotalAmountAttributes()
    {
        return $this->amount * $this->quantity;
    }

}
