<?php

namespace App\Models;

use App\Traits\AddingCompany;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InventoryProduct extends Model
{
    use AddingCompany;
    protected $fillable = [
        'category_id', 'unit_id', 'wholesale_unit_id', 'brand_id', 'generic_id', 'medicine_type_id',
        'retail_quantity', 'retail_sales_price', 'retail_unit_tp', 'pack_size',
        'name', 'strength', 'stock_limitation', 'status',
        'created_by', 'updated_by', 'company_id',
    ];


//    relationship started
    public function brand()
    {
        return $this->belongsTo(InventoryBrand::class,'brand_id','id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function unit()
    {
        return $this->belongsTo(InventoryUnit::class,'unit_id','id');
    }

    public function wholesaleUnit()
    {
        return $this->belongsTo(InventoryUnit::class,'wholesale_unit_id','id');
    }
    public function category()
    {
        return $this->belongsTo(InventoryCategory::class,'category_id','id');
    }
    public function barcode()
    {
        return $this->hasOne(InventoryProductBarcode::class, 'inventory_product_id');
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
