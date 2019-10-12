<?php

namespace App\Http\Requests\Pharmacy;

use App\Models\Inventory\Product;
use App\Models\Inventory\ProductSale;
use App\Models\InventoryProduct;
use App\Models\InventoryProductSale;
use App\Traits\HospitalPaymentTrait;
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
                'invoice_id', 'patient_id', 'date', 'amount', 'discount', 'paid', 'change'
            );

            $invoice = ProductSale::create($input);


            $this->saleItems($invoice);

//            $this->salePayment($invoice);

            return $invoice;

        });
    }

    private function saleItems(ProductSale $invoice)
    {
        $items = $invoice->items;
        foreach ($this->get('product_id', []) as $key => $productId){
            $invoice->items()->create([
                'product_id' => $productId,
                'product_code_id' => $this->product_code_id[$key],
                'sales_qty' => $this->sales_qty[$key],
                'amount' => $this->sales_price[$key],
                'unit_tp' => $this->item_price[$key],
            ]);

            $item = $items->firstWhere('product_code_id', $this->product_code_id[$key]);

//            dump($items, $this->product_code_id[$key]);
            $item->productCode()->update([
                'quantity' => $item->productCode->quantity - $this->sales_qty[$key]
            ]);


            $product = Product::find($productId);
            $product->update([
                'quantity' => $product->quantity - $this->sales_qty[$key]
            ]);



        }
    }

//    private function salePayment($invoice)
//    {
//        $paidAmount = $this->paid_amount;
//
//        $paidAmount >= $this->grand_total ?
//            $paidAmount =  $this->grand_total : false;
//
//        $this->payment($invoice, $paidAmount);
//    }
}
