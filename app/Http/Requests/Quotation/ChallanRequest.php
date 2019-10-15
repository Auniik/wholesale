<?php

namespace App\Http\Requests\Quotation;

use App\Models\Quotation\Challan;
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
        return [
            'quantity.*' => 'lte:available_qty.*',
            'transport_mode' => 'required|max:160',
            'shipping_address' => 'required|max:192',
            'quotation_id' => 'required',
            'party_id' => 'required',
            'date' => 'required',
            'invoice_id' => 'required',
        ];
    }

    public function persist()
    {
        DB::transaction(function (){
            $challan = $this->makeInvoice();

            $test = $this->addItems($challan);

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
                    'product_id' => $this->product_id[$key],
                    'product_code_id' => $this->product_code_id[$key],
                    'quantity' => $this->quantity[$key],
                ]);

                $item->inventoryUpdate($quantity);

//                $item->product()->update([
//                    'quantity' => $challan->product - $this->quantity[$key],
//                ]);
            }
        }
    }
}
