<?php

namespace App\Models\Inventory;

use App\Models\Party;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ProductSale extends Model
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
            $model->items->each->delete();
            $model->payments->each->delete();

            foreach ($model->items as $item){
                $item->productCode()->update([
                    'quantity' => $item->productCode->quantity + $item->quantity,
                ]);
            }
        });
    }

    protected $fillable = [
        'invoice_id', 'party_id', 'date', 'amount', 'discount', 'paid', 'change',
        'company_id', 'created_by', 'updated_by'
    ];

    protected $dates = [
        'date'
    ];

    public function items()
    {
        return $this->hasMany(ProductSaleItem::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getTotalAmountAttribute()
    {
        return $this->amount - $this->discount;
    }

    public function payments()
    {
        return $this->morphMany(InventoryTransaction::class, 'transactionable');
    }

    public function payment()
    {
        return $this->morphOne(InventoryTransaction::class, 'transactionable')
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
        return $this->hasMany(ProductSaleItem::class, 'inventory_product_sale_id')
            ->selectRaw('sum(sales_qty) as quantity, sum(sales_price) as amount, 
            inventory_products.name as product_name, inventory_product_sale_items.product_id as product_id, 
            inventory_product_sale_id')
            ->join('inventory_products','inventory_product_sale_items.product_id', '=', 'inventory_products.id')
            ->groupBy('product_id');
    }
}
