<?php

namespace App\Models\Quotation;

use App\Models\Inventory\Product;
use App\Models\Party;
use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class Challan extends Model
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
                foreach ($model->items as $item){

                    $item->itemsDelivered->each->delete();
                }
                $model->items->each->delete();
            });
        }

    }
    protected $fillable = [
        'company_id', 'quotation_id', 'party_id', 'created_by', 'updated_by', 'shipping_address',
        'date', 'invoice_id', 'transport_mode',
    ];

    protected $dates = [
        'date'
    ];

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($date));
    }

    public function items()
    {
        return $this->hasMany(ChallanItem::class, 'challan_id');
    }



    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }
    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }



}
