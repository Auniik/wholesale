<?php

namespace App\Models;

use App\Models\Accounts\Transaction;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Arr;

class InventoryProductPurchase extends Model
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
                'updated_by' => auth()->id(),
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);
        });
        static::deleting(function ($model){
            foreach ($model->items as $item){
                $inventoryProduct = InventoryProduct::where('id', $item->product_id)->first();
                $inventoryProduct->update([
                    'retail_quantity' => $inventoryProduct->retail_quantity - $item->retail_quantity
                ]);
            }
            $model->payments->each->delete();

        });
    }


    protected $fillable = [
        'company_id', 'created_by', 'updated_by', 'manufacturer_id', 'challan_id', 'date' ,
        'subtotal', 'total_vat', 'discount', 'paid_amount', 'approved_by', 'approved_at'
    ];

    protected $dates = ['date'];





    public function items()
    {
        return $this->hasMany(InventoryProductPurchaseItem::class);
    }


    public function manufacturer()
    {
        return $this->belongsTo(InventoryBrand::class, 'manufacturer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTotalAmountAttribute()
    {
        return ($this->subtotal + $this->total_vat) - $this->discount;
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
        return abs(Arr::get($this->payment, 'amount', 0));
    }

    public function getDueAttribute()
    {
        if ($this->paid){
            return $this->totalAmount - $this->paid;
        }
        return $this->totalAmount - $this->paid_amount;
    }


    public function report()
    {
        return $this->hasMany(InventoryProductPurchaseItem::class, 'inventory_product_purchase_id')
            ->selectRaw('sum(inventory_product_purchase_items.retail_quantity) as quantity, sum(retail_unit_tp) as amount, 
            inventory_product_purchase_id, product_id, inventory_products.name as name, inventory_units.name as unit_name,
            inventory_brands.name as manufacturer_name
            ')
            ->join('inventory_products','inventory_product_purchase_items.product_id', '=', 'inventory_products.id')
            ->join('inventory_brands','inventory_products.brand_id', '=', 'inventory_brands.id')
            ->join('inventory_units','inventory_products.unit_id', '=', 'inventory_units.id')
            ->groupBy('product_id');
    }
}
