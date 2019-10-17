<?php

namespace App\Http\Requests\Quotation;

use App\Models\Quotation\Challan;
use App\Models\Quotation\ChallanItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ChallanRequest extends FormRequest
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
            'quantity.*' => 'lte:available_qty.*',
            'transport_mode' => 'required|max:160',
            'shipping_address' => 'required|max:192',
            'quotation_id' => 'required',
            'party_id' => 'required',
            'date' => 'required',
            'invoice_id' => 'required',
        ];
        foreach ($this->get('product_id', []) as $key => $product){
            $rules += [
                "product_code_name.{$key}" => $this->checkCode($key)
            ];
        }
        return $rules;
    }
    private function checkCode($key) : string
    {
        if($this->quantity[$key] > 0){
            return 'required';
        }
        return 'nullable';
    }

    public function persist()
    {
        return DB::transaction(function (){
            $challan = $this->makeInvoice();

            $this->addItems($challan);

            return $challan;
        });
    }

    private function makeInvoice() : Challan
    {
        $input = $this->only('party_id', 'invoice_id', 'date', 'transport_mode', 'shipping_address', 'quotation_id');
        return Challan::create($input);
    }

    private function addItems(Challan $challan)
    {

        foreach ($this->quantity as $key => $quantity){
            if ($quantity){
                $item = $challan->items()->create([
                    'quotation_item_id' => $this->quotation_item_id[$key],
                    'product_code_id' => $this->product_code_id[$key],
                    'quantity' => $this->quantity[$key],
                ]);
                /** @var ChallanItem $item */
                $item->productCode()->update([
                    'quantity' => $item->productCode->quantity - $quantity
                ]);
                $item->quotationItem->product()->update([
                    'quantity' => $item->quotationItem->product->quantity - $quantity
                ]);

//                dd($item);


            }
        }
    }
}
