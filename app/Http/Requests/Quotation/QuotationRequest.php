<?php

namespace App\Http\Requests\Quotation;

use App\Models\Quotation\Quotation;
use App\Models\Quotation\QuotationItem;
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

    public function update(Quotation $quotation)
    {
        return DB::transaction(function ()use($quotation){
            $attributes = $this->only(
                'validity', 'date', 'shipping_address', 'amount', 'discount'
            );
            $quotation->update($attributes);

            $ids = [];

            foreach ($this->id as $key => $id)
            {
                $item = $quotation->items()->find($id);

                $attributes = $this->itemAttributes($key);

                if($item){
                    $ids[] = $item->id;
                    $item->update($attributes);
                }
                else{
                    $item = $quotation->items()->create($attributes);
                    $ids[] = $item->id;
                }

            }
            $quotation->items->whereNotIn('id', $ids)->each->delete();

            return $quotation;
        });
    }
}
