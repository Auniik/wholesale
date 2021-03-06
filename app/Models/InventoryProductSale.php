<?php

namespace App\Models;

use App\Models\Accounts\Transaction;
use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class InventoryProductSale extends Model
{
    public static function boot()
    {
        parent::boot();

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
                $inventoryProduct = InventoryProduct::where('id', $item->product_id)->first();
                $inventoryProduct->update([
                    'retail_quantity' => $inventoryProduct->retail_quantity + $item->retail_quantity
                ]);
            }
            $model->payments->each->delete();
        });
    }

    protected $fillable = [
        'invoice_id', 'patient_id', 'patient_name', 'date', 'subtotal', 'discount', 'previous_due', 'paid_amount', 'due_amount',
        'change_amount', 'company_id', 'created_by', 'updated_by'
    ];

    protected $dates = [
        'date'
    ];

    public function items()
    {
        return $this->hasMany(InventoryProductSaleItem::class);
    }

//    public function patient()
//    {
//        return $this->belongsTo(Patient::class, 'patient_id');
//    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getTotalAmountAttribute()
    {
        return $this->subtotal - $this->discount;
    }

    public function payments()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function payment()
    {
        return $this->morphOne(Transaction::class, 'transactionable')
            ->selectRaw('sum(amount) as amount, transactionable_id')
            ->groupBy('transactionable_id');
    }
    public function getPaidAttribute()
    {
        return Arr::get($this->payment, 'amount', 0);
    }

    public function getDueAttribute()
    {
        return $this->totalAmount - $this->paid;
    }


    public function report()
    {
        return $this->hasMany(InventoryProductSaleItem::class, 'inventory_product_sale_id')
            ->selectRaw('sum(sales_qty) as quantity, sum(sales_price) as amount, 
            inventory_products.name as product_name, inventory_product_sale_items.product_id as product_id, 
            inventory_product_sale_id')
            ->join('inventory_products','inventory_product_sale_items.product_id', '=', 'inventory_products.id')
            ->groupBy('product_id');
    }
}
