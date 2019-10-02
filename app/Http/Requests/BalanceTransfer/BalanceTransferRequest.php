<?php

namespace App\Http\Requests\BalanceTransfer;

use App\Models\BalanceTransfer;
use App\Traits\FileUploadTrait;
use Illuminate\Foundation\Http\FormRequest;

class BalanceTransferRequest extends FormRequest
{
    use FileUploadTrait;
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
            'date' => 'required',
            'transfer_from' => 'required',
            'transfer_to' => 'required',
            'amount' => 'required|numeric|min:1',
            'bank_slip' => 'required',
        ];
    }

    public function store()
    {
        $data = $this->except('bank_slip');
        $data['bank_slip'] = $this->uploadImageWithoutResize('bank_slip', 'bank_slips');

        BalanceTransfer::create($data);
    }
}
