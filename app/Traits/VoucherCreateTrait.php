<?php
/**
 * Created by PhpStorm.
 * User: dev7
 * Date: 8/5/19
 * Time: 4:33 PM
 */

namespace App\Traits;


use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherSectorPayment;
use Illuminate\Support\Facades\DB;


trait VoucherCreateTrait
{
    use PartyCreateIfNotExistsTrait;
    use InstallmentsTrait;

    protected function voucher($type, $payment_type)
    {
        $partyId = $this->getParty($this->party_id);
        $data = $this->only('date', 'ref_id', 'cheque_no');
        $data['amount'] = $this->totalPayable;
        $data['type'] = $type;
        $data['payment_type'] = $payment_type;
        $data['party_id'] = $partyId;

        $voucher = Voucher::create($data);

        return [
            'invoice' => $voucher,
            'paymentInfo' => $this->voucherPaymentInfo($voucher),
            'type' => $type,
        ];
    }


    protected function voucherPaymentInfo($voucher)
    {
        return $voucher->payments()->create([
            'account_id' => $this->account_id,
            'method_id' => $this->method_id,
        ]);
    }

    protected function voucherSectorCreate($voucher)
    {
        foreach ($this->get('chart_of_account_id', []) as $key => $account){

            $voucherSector = $voucher['invoice']->sectors()->create([
                'description' => $this->description[$key],
                'sector_id' => $this->chart_of_account_id[$key],
                'amount' => $this->payable_amount[$key],
            ]);

            if ($this->paid_amount[$key]) {
                $this->voucherSectorPayments($voucher, $voucherSector, $key);
            }

        }

    }

    protected function voucherSectorPayments($voucher, $voucherSector, $key)
    {
        /** @var VoucherSectorPayment $payment */
        $payment = $voucher['invoice']->sectorPayments()->create([
            'sector_id' => $voucherSector->id,
            'account_id' => $this->account_id,
            'method_id' => $this->method_id,
            'voucher_payment_id' => $voucher['paymentInfo']->id
        ]);

        $amount = $voucher['type']=='debit' ? -$this->paid_amount[$key] : $this->paid_amount[$key];

        if ($voucher['type']=='credit'){
            $payment->payments()->create([
                'account_id' => $this->account_id,
                'amount' => $amount,
            ]);
        }
        $payment->update([
            'paid_amount' => $this->paid_amount[$key],
        ]);

    }

    public function createVoucher($type, $payment_type)
    {
        return DB::transaction(function ()use($type, $payment_type){

            $voucher = $this->voucher($type, $payment_type);
            $this->voucherSectorCreate($voucher);

            //Optional
            if ($voucher['type'] != 'credit') $this->installment($voucher['invoice']);

            return $voucher['invoice'];
        });

    }
}