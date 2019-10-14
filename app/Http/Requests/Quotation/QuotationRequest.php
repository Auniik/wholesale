<?php

namespace App\Http\Requests\Quotation;

use App\Models\Quotation\Quotation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class QuotationRequest extends FormRequest
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
            //
        ];
    }

    public function persist() : Quotation
    {
        return DB::transaction(function (){
            $invoice = $this->makeQuotation();


            foreach ($this->get('quantity') as $key => $quantity){
                if($quantity){

                    $attributes = $this->itemAttributes($key);
                    /** @var Quotation $invoice */
                    $invoice->items()->create($attributes);

                }
            }
            return $invoice;
        });
    }

    public function makeQuotation() : Quotation
    {
        $attributes = $this->only(
            'party_id', 'validity', 'invoice_id', 'date', 'shipping_address', 'amount', 'discount'
        );


        return Quotation::create($attributes);
    }

    protected function itemAttributes($key) : array
    {
        return [
            'product_id' => $this->product_id[$key],
            'quantity' => $this->quantity[$key],
            'unit_tp' => $this->unit_tp[$key],
            'amount' => $this->sales_price[$key],
        ];
    }
}
