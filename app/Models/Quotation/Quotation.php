<?php

namespace App\Models\Quotation;

use App\Models\Party;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    public static function boot()
    {
        parent::boot();

        if (!app()->runningInConsole()){
            static::creating(function ($model){
                /** @var User $user */
                $user = auth()->user();
                $model->fill([
                    'company_id' => $user->fk_company_id,
                    'created_by' => $user->id
                ]);
            });

            static::updating(function ($model){
                $model->fill([
                    'updated_by' => auth()->id()
                ]);
            });

            static::deleting(function ($model){
                $model->items->each->delete();
                foreach ($model->challans as $challan){
                    $challan->items->each->delete();
                }
                $model->challans->each->delete();
            });
        }

    }
    protected $fillable = [
        'party_id', 'created_by', 'company_id', 'updated_at ', 'updated_by', 'bank_id', 'validity', 'shipping_address',
        'amount', 'discount', 'invoice_id'
    ];

    protected function setValidityAttribute($date)
    {
        $this->attributes['validity'] =  date('Y-m-d', strtotime($date));
    }

    protected $dates = [
        'validity', 'created_at'
    ];

    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }

    public function getChallanItemsAttribute()
    {
        $items = ChallanItem::query()
            ->with('productCode.product', 'quotationItem')
            ->whereHas('challan.quotation', function($q){
                $q->where('id', $this->id);
            })->selectRaw('sum(challan_items.quantity) as quantity,
            challan_items.quotation_item_id, challan_items.product_code_id')
            ->groupBy('product_code_id');
        return $items->get();
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
