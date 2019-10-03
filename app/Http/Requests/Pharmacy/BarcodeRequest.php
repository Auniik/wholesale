<?php

namespace App\Http\Requests\Pharmacy;

use App\Models\Inventory\Barcode;
use App\Models\InventoryProductBarcode;
use Illuminate\Foundation\Http\FormRequest;
use Picqer;

class BarcodeRequest extends FormRequest
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
            'product_name.*' => 'required|distinct',
            'product_id.*' => 'required|distinct',
//            'number.*' => 'required|distinct|unique:inventory_product_barcodes',
        ];
    }

    public function persist()
    {
        foreach ($this->product_id as $key => $productId){
            Barcode::create([
                'number' => $this->number[$key],
                'product_id' => $productId,
            ]);
        }
        return true;
    }
}
