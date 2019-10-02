<?php

namespace App\Http\Requests\Voucher;

use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherSectorPayment;
use App\Models\VoucherPayment;
use App\Traits\AdvanceAdjustmentAndInstallmentTrait;
use App\Traits\PartyCreateIfNotExistsTrait;
use App\Traits\VoucherCreateTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;


class StoreDebitVoucherRequest extends FormRequest
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
            'chart_of_account.*' => 'required',
            'chart_of_account_id.*' => 'required',
            'description.*' => 'required',
            'payable_amount.*' => 'required',
            'account_id' => 'required',
            'method_id' => 'required'
        ];
    }


    public function store($payment_type = 'partial')
    {
        return $this->createVoucher('debit', $payment_type);

    }

}
