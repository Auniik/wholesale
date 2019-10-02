<?php
/**
 * Created by PhpStorm.
 * User: dev7
 * Date: 10/1/19
 * Time: 11:04 AM
 */

namespace App\Traits;

use App\Models\Accounts\Voucher;

trait InstallmentsTrait
{
    public function installment($voucher)
    {
        if ($this->payViaInstallment){
            foreach ($this->get('purpose', []) as $key => $purpose) {
                /** @var Voucher $voucher */
//                dd($voucher->instalments);
                $voucher->installments()->create([
                    'purpose' => $purpose,
                    'date' => $this->installment_date[$key],
                    'amount' => $this->installment_amount[$key],
                ]);
            }
        }
        return $voucher->installments;
    }

    public function updateInstallments($voucher) : void
    {
        $ids = [];
        foreach ($this->get('installment_id', []) as $key => $id) {

            $installment = $voucher->installments->find($id);

            $ids[] = $id;
            if ($installment){
                $installment->update([
                    'purpose' => $this->purpose[$key],
                    'date' => $this->installment_date[$key],
                    'amount' => $this->installment_amount[$key],
                ]);
            }else{
                $ids[] = $voucher->installments()->create([
                    'purpose' => $this->purpose[$key],
                    'date' => $this->installment_date[$key],
                    'amount' => $this->installment_amount[$key],
                ])->id;
            }
        }
        $voucher->installments->whereNotIn('id', $ids)->each->delete();
    }


    public function partialPayment($voucher)
    {

    }
}