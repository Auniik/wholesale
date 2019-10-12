<?php

namespace App\Http\Requests\Pharmacy;

use App\Models\Inventory\Product;
use App\Models\Inventory\ProductCode;
use App\Models\Inventory\ProductPurchase;
use App\Models\Inventory\ProductPurchaseItem;
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

        foreach ($this->get('product_id', []) as $key => $product){
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
                        $item = $purchase->items()->create($attributes);

                        $this->updateCodeQuantity($item, $key);

                        $this->updateQuantity($key, $this->product_id[$key]);
                    }
                }

                $this->payment($purchase, -$this->paid_amount);
                return $purchase;
            }

        });

    }

    protected function purchaseCreate()
    {
        $input = $this->only(
            'manufacturer_id', 'challan_id', 'date', 'quantity', 'amount'
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
            $productId = $this->product_id[$key];
            $code = ProductCode::where([
                ['name', $codeName],
                ['product_id', $productId],
            ])->first();

            return $codeId = $code ? $code->id : ProductCode::create([
                'name' => $codeName,
                'product_id' => $productId
            ])->id;
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


    private function payment(ProductPurchase $purchase, $amount) : void
    {
        $purchase->payments()->create([
            'amount' => $amount
        ]);
    }

    private function updateCodeQuantity(ProductPurchaseItem $item, $key)
    {
        $item->productCode()->update([
            'quantity' => $item->productCode->quantity + $this->quantity[$key],
        ]);
    }


}
