<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'  =>  $this->name,
            'todaySale' =>  $this->todaySaleQty,
            'todayPurchase' =>  $this->todayPurchaseQty,
            'retail_quantity'   =>  $this->retail_quantity,
            'retail_sales_price'    =>  $this->retail_sales_price,
            'unit_name' =>  $this->unit->name,
        ];
    }
}
