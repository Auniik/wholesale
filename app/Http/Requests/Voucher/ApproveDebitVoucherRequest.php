<?php

namespace App\Http\Requests\Voucher;

use App\Models\Accounts\VoucherSector;
use App\Models\VoucherPayment;
use App\Traits\AdvanceAdjustmentAndInstallmentTrait;
use App\Traits\InstallmentsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ApproveDebitVoucherRequest extends FormRequest
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
            //
        ];
    }

    public function approve($voucher)
    {
        return DB::transaction(function () use ($voucher) {

           $this->updateApproval($voucher);

            /** @var VoucherPayment $voucherPayment */
            $voucherPayment = $voucher->payments()->update([
                'account_id' => $this->account_id,
                'method_id' => $this->method_id,
            ]);

            $chartIds = [];

            foreach ($this->get('id') as $key => $chart_id){
                $chart = VoucherSector::find($chart_id);
                /** @var VoucherSector $chart */
                $chartIds[] = $chart_id;
                if ($chart){

                    $this->chartsUpdate($chart, $key);

                }
                else{
                    $chart = $this->chartsCreate($voucher, $key);
                    $chartIds[] = $chart->id;

                    $chartsPayment = $voucher->sectorPayments()->create([
                        'sector_id' => $chart->id,
                        'paid_amount' => $this->paid_amount[$key],
                        'account_id' => $this->account_id,
                        'method_id' => $this->method_id,
                        'voucher_payment_id' => $voucher->payments->first()->id
                    ]);
                    $this->chartsPaymentUpdate($chart->sectorPayments, $key);
                }
            }
            $voucher->sectors->whereNotIn('id', $chartIds)->each->delete();

            $this->updateInstallments($voucher);

            return $voucher;
        });
    }

    private function updateApproval($voucher)
    {
        $data = [
            'ref_id' => $this->ref_id,
            'cheque_no' => $this->cheque_no,
            'amount' => $this->totalPayable,
            'date' => $this->date,
            'party_id' => $this->party_id
        ];

        $voucher->update($data);

        if ($this->isConfirm){
            return $voucher->update([
                'confirmed_by' => auth()->id(),
                'confirmed_at' => now()
            ]);
        }else{
            $voucher->update([
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);
        }
    }


    public function chartsUpdate($chart, $key)
    {
        $chart->update([
            'description' => $this->description[$key],
            'sector_id' => $this->chart_of_account_id[$key],
            'amount' => $this->payable_amount[$key],
        ]);

        $this->chartsPaymentUpdate($chart->sectorPayments, $key);
    }

    private function chartsPaymentUpdate($chartPayments, $key)
    {
        if ($this->paid_amount[$key]){
            foreach ($chartPayments as $k => $payment){
                $this->pay($payment, $key);
            }
        }
    }

    private function pay($payment, $key)
    {
        if (!$this->isConfirm){
            $payment->payments()->create([
                'account_id' => $this->account_id,
                'amount' => -$this->paid_amount[$key],
            ]);
        }
        $payment->update([
            'paid_amount' => $this->paid_amount[$key],
        ]);
    }

    private function chartsCreate($voucher, $key)
    {
        return $voucher->sectors()->create([
            'description' => $this->description[$key],
            'sector_id' => $this->chart_of_account_id[$key],
            'amount' => $this->payable_amount[$key],
        ]);
    }


}
