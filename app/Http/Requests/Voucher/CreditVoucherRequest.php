<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Support\Facades\DB;
use App\Traits\VoucherCreateTrait;
use Illuminate\Foundation\Http\FormRequest;

class CreditVoucherRequest extends FormRequest
{
    use VoucherCreateTrait;
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
            'party_name' => 'required',
            'date' => 'required',
            'chart_of_account.*' => 'required|distinct',
            'chart_of_account_id.*' => 'required|distinct',
            'description.*' => 'required',
            'payable_amount.*' => 'required',
            'account_id' => 'required',
            'method_id' => 'required'
        ];
    }

    public function persist()
    {
        return $this->createVoucher('credit', 'partial');
    }
}
