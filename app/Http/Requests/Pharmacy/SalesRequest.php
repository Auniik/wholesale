<?php

namespace App\Http\Requests\Pharmacy;

use App\Models\Inventory\Product;
use App\Models\Inventory\ProductSale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class SalesRequest extends FormRequest
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
            'party_id' => 'required',
            'party_name' => 'required',
            'code_names.*' => 'required',
            'sales_qty.*' => 'required',
            'product_code_id.*' => 'required',
        ];
    }

    public function persist()
    {
        return DB::transaction(function () {
            $input =  $this->only(
                'invoice_id', 'party_id', 'date', 'amount', 'discount', 'change'
            );

            $invoice = ProductSale::create($input);


            $this->saleItems($invoice);
            $this->payment($invoice);

            return $invoice;

        });
    }

    private function saleItems(ProductSale $invoice)
    {
        foreach ($this->get('product_id', []) as $key => $productId){
            $item = $invoice->items()->create([
                'product_id' => $productId,
                'product_code_id' => $this->product_code_id[$key],
                'quantity' => $this->sales_qty[$key],
                'amount' => $this->sales_price[$key],
                'unit_tp' => $this->item_price[$key],
            ]);

            $item = $item->where('product_code_id', $this->product_code_id[$key])->first();

            $item->productCode()->update([
                'quantity' => $item->productCode->quantity - $this->sales_qty[$key]
            ]);

            $product = Product::find($productId);
            $product->update([
                'quantity' => $product->quantity - $this->sales_qty[$key]
            ]);



        }
    }

    private function payment(ProductSale $sale) : void
    {
        $paidAmount =  $this->paid >= $this->grand_total
            ? $this->grand_total
            :  $this->paid;


        $sale->payments()->create([
            'amount' => $paidAmount
        ]);
    }

}
