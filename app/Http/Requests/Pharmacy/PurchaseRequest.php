<?php

namespace App\Http\Requests\Pharmacy;

use App\Models\InventoryProduct;
use App\Models\InventoryProductPurchase;
use App\Models\InventoryProductPurchaseItem;
use App\Traits\HospitalPaymentTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PurchaseRequest extends FormRequest
{
    use HospitalPaymentTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'product_id.*' => 'required|distinct',
            'sales_price.*' => 'required',
            'quantity.*' => 'required',
            'date' => 'required',
            'discount' => 'required',
            'paid_amount' => 'required',
        ];
        switch ($this->method()){
            case 'PATCH':
            case 'PUT':
                $rules['manufacturer_id'] = '';
                return $rules;
                break;
            case 'POST':
                $rules['manufacturer_id'] = 'required';
                return $rules;
        }
    }

    protected function itemAttributes($key)
    {
        return [
            'product_id' => $this->product_id[$key],
            'pack_size' => $this->pack_size[$key],
            'quantity' => $this->quantity[$key],
            'retail_quantity' => $this->retail_quantity[$key],
            'unit_tp' => $this->unit_tp[$key],
            'sales_price' => $this->sales_price[$key],
            'retail_sales_price' => $this->retail_sales_price[$key],
            'unit_vat' => $this->unit_vat[$key],
            'expiry_date' => $this->expiry_date[$key],
        ];
    }

    public function store()
    {
        return DB::transaction(function (){
            if (!array_filter($this->get('retail_quantity'), function($v){return $v !== null;})){
                return false;
            }else{

                $purchase = $this->purchaseCreate();

                foreach ($this->get('retail_quantity') as $key => $retail_quantity){
                    if($retail_quantity){

                        $attributes = $this->itemAttributes($key);

                        $purchase->items()->create($attributes);

                        $this->updateQuantity($key, $this->product_id[$key]);
                    }
                }

//                $this->payment($purchase, -$this->paid_amount);
                return $purchase;
            }

        });

    }

    protected function purchaseCreate()
    {
        $input = $this->except(
            'product_name', 'party_name', 'product_id', 'pack_size', 'quantity', 'unit_tp',
            'sales_price', 'unit_vat', 'amount', 'expiry_date'
        );
        return InventoryProductPurchase::create($input);
    }

    protected function updateQuantity($key, $item)
    {
        $data = [
            'retail_quantity' => $this->retail_quantity[$key],
            'retail_unit_tp' => $this->retail_unit_tp[$key],
            'retail_sales_price' => $this->retail_sales_price[$key],
            'pack_size' => $this->pack_size[$key],
        ];
        $inventory_product = InventoryProduct::where('id', $item)->first();
        if ($inventory_product){
            $data['retail_quantity'] += $inventory_product->retail_quantity;
            $inventory_product->update($data);
        }
    }

    public function approve($purchase)
    {
        return DB::transaction(function () use ($purchase) {

            $purchase->update([
                'subtotal' => $this->subtotal,
                'discount' => $this->discount,
                'paid_amount' => $this->paid_amount,
            ]);
            foreach ($this->get('id', []) as $key => $id){

                $item = InventoryProductPurchaseItem::find($id);
                /** @var InventoryProductPurchaseItem $item */

                $item->update($this->itemAttributes($key));

                $this->updateQuantity($key, $this->product_id[$key]);
            }

        $this->payment($purchase, -$this->paid_amount);

            return true;
        });
    }

}
