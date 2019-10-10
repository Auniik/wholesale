<?php

namespace App\Http\Requests\Pharmacy;

use App\Models\Inventory\Product;
use App\Models\Inventory\ProductCode;
use App\Models\Inventory\ProductPurchase;
use App\Models\InventoryProductPurchaseItem;
use App\Rules\PurchaseProductCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PurchaseRequest extends FormRequest
{
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
//            'product_code_name.*' => "required_if:quantity.*,>,0",
            'sales_price.*' => 'required',
            'quantity.*' => 'required',
            'date' => 'required',
            'discount' => 'required',
            'paid_amount' => 'required',
        ];

        foreach ($this->product_id as $key => $product){
            $rules += [
                "product_code_name.{$key}" => $this->checkCode($key)
            ];

        }

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

    private function checkCode($key) : string
    {
        if($this->quantity[$key] > 0){
            return 'required';
        }
        return 'nullable';
    }

    public function store()
    {
//        dd($this->all());
        return DB::transaction(function (){
            if (!array_filter($this->get('quantity'), function($v){return $v !== null;})){
                return false;
            }else{

                $purchase = $this->purchaseCreate();

                foreach ($this->get('quantity') as $key => $quantity){
                    if($quantity){

                        $attributes = $this->itemAttributes($key);

                        /** @var ProductPurchase $purchase */
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
        $input = $this->only(
            'manufacturer_id', 'challan_id', 'date', 'quantity', 'subtotal'
        );
        return ProductPurchase::create($input);
    }

    protected function itemAttributes($key)
    {
        return [
            'product_id' => $this->product_id[$key],
            'product_code_id' => $this->codeCreate($key),
            'quantity' => $this->quantity[$key],
            'unit_price' => $this->unit_tp[$key],
            'sales_price' => $this->sales_price[$key],
            'expiry_date' => $this->expiry_date[$key],
        ];
    }

    public function codeCreate($key)
    {
        if ($this->product_code_name[$key]){
            $codeName = trim($this->product_code_name[$key]);
            $code = ProductCode::where('name', $codeName)->first();
            return $code ? $code->id : ProductCode::create([ 'name' => $codeName ]);
        }
    }

    protected function updateQuantity($key, $item)
    {
        $data = [
            'quantity' => $this->quantity[$key],
            'unit_price' => $this->unit_tp[$key],
            'sales_price' => $this->sales_price[$key],
        ];
        $product = Product::where('id', $item)->first();
        if ($product){
            $data['quantity'] += $product->quantity;
            $product->update($data);
        }
    }







    public function approve($purchase)
    {
        return DB::transaction(function () use ($purchase) {

            $purchase->update([
                'amount' => $this->amount,
                'discount' => $this->discount,
                'paid_amount' => $this->paid_amount,
            ]);

            foreach ($this->get('id', []) as $key => $id){

                $item = InventoryProductPurchaseItem::find($id);
                /** @var InventoryProductPurchaseItem $item */

                $item->update($this->itemAttributes($key));

                $this->updateQuantity($key, $this->product_id[$key]);
            }

//        $this->payment($purchase, -$this->paid_amount);

            return true;
        });
    }

}
