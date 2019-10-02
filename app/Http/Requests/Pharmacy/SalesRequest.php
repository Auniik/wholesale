<?php

namespace App\Http\Requests\Pharmacy;

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
            //
        ];
    }

    public function persist()
    {
        return DB::transaction(function () {

            $input =  $this->only('invoice_id', 'patient_name', 'patient_id', 'date', 'subtotal', 'discount', 'previous_due', 'paid_amount', 'due_amount');

            $invoice = InventoryProductSale::create($input);

            $this->saleItems($invoice);

            $this->salePayment($invoice);

            return $invoice;

        });
    }

    private function saleItems($productSale)
    {
        foreach ($this->get('product_id', []) as $key => $item){
            $productSale->items()->create([
                'product_id' => $item,
                'sales_qty' => $this->sales_qty[$key],
                'sales_price' => $this->sales_price[$key],
                'item_price' => $this->item_price[$key],
            ]);
            $inventoryProduct = InventoryProduct::find($item);
            $inventoryProduct->update([
                'retail_quantity' => $inventoryProduct->retail_quantity - $this->sales_qty[$key]
            ]);

        }
    }

    private function salePayment($invoice)
    {
        $paidAmount = $this->paid_amount;

        $paidAmount >= $this->grand_total ?
            $paidAmount =  $this->grand_total : false;

        $this->payment($invoice, $paidAmount);
    }
}
