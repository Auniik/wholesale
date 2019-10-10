<?php

namespace App\Models\Inventory;

use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use AddingCompany;
    protected $fillable = [
        'category_id',  'manufacturer_id', 'quantity', 'unit_price', 'sales_price',
        'name', 'stock_limitation', 'status',
        'created_by', 'updated_by', 'company_id',
    ];


//    relationship started
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class,'manufacturer_id','id');
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function barcode()
    {
        return $this->hasOne(Barcode::class, 'product_id');
    }

    public function codes()
    {
        return $this->hasMany(ProductCode::class, 'product_id');
    }
    //Product Sale
    public function salesItems()
    {
        return $this->hasMany(InventoryProductSaleItem::class, 'product_id', 'id');
    }

    public function purchaseItems()
    {
        return $this->hasMany(InventoryProductPurchaseItem::class, 'product_id', 'id');
    }

    //TodaySale
    public function todaySalesItems()
    {
        return $this->todayReportableItems(InventoryProductSaleItem::class);
    }

    public function getTodaySaleQtyAttribute()
    {
        return $this->todaySalesItems->sum('sales_qty');
    }

    public function getTodayPurchaseQtyAttribute()
    {
        return $this->todayPurchaseItems->sum('retail_quantity');
    }

    //todayPurchase
    public function todayPurchaseItems()
    {
        return $this->todayReportableItems(InventoryProductPurchaseItem::class);
    }

    protected function todayReportableItems($model)
    {
        $date = "'".date('Y-m-d')."'";
        return $this->hasMany($model, 'product_id', 'id')
            ->whereRaw('date(created_at) = '.$date);
    }
}
