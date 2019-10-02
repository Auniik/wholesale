<?php

namespace App\Http\Requests\Voucher;

use App\Models\Accounts\VoucherSectorPayment;
use App\Models\Installment;
use App\Traits\InstallmentsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class VoucherPaymentRequest extends FormRequest
{
    use InstallmentsTrait;
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
            'account_id' => 'required',
            'method_id' => 'required',
//            'totalPaid' => 'required|numeric|max:' . $voucher->due()
        ];
    }

    public function persist($voucher)
    {
        $total = $this->totalPaid;

        return DB::transaction(function ()use($total, $voucher){

            //installment Section
            $this->updateInstallments($voucher);

            if (!empty($this->installment_check)){
                /** @var Installment $installment */
                foreach ($this->installment_check as $id){
                    $installment = $voucher->installments()->find($id);
                    $installment->update([
                        'status' => 'paid',
                        'paid_date' => now()
                    ]);
                }

            }

            $voucherPayment = $voucher->payments()->create([
                'account_id' => $this->account_id,
                'method_id' => $this->method_id,
            ]);

            foreach ($voucher->sectors as $sector){
                if($total  == 0){
                    break;
                }
                /** @var VoucherSectorPayment $payment */
                $payment = $voucher->sectorPayments()->create([
                    'voucher_payment_id' => $voucherPayment->id,
                    'sector_id' => $sector->id,
                    'account_id' => $this->account_id,
                    'method_id' => $this->method_id,
                ]);

                if($total < $sector->due){

                    $payment->payments()->create([
                        'amount' => ($voucher->isDebit() ?  - $total : $total),
                        'account_id' => $this->account_id,
                    ]);

                    break;
                }

                $payment->payments()->create([
                    'amount' => ($voucher->isDebit() ?  -$sector->due : $sector->due),
                    'account_id' => $this->account_id,
                ]);

                $total -= $sector->due;

            }

            return $voucherPayment;
        });
    }
}
