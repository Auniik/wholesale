<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Accounts\Transaction;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherSectorPayment;
use App\Models\DoctorAppointment;
use App\Models\HospitalServiceSale;
use App\Models\IndoorPatientBooking;
use App\Models\InventoryProductPurchase;
use App\Models\InventoryProductSale;
use App\Models\PettyCashDeposit;
use App\Models\PettyCashTransaction;
use App\Models\PettyCashVoucher;
use App\Models\Procurement\EquipmentPurchaseItemPayment;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pettyCashDeposit = $this->getGrossIncome(PettyCashDeposit::class, PettyCashTransaction::class);
        $pettyCashExpense = $this->getGrossIncome(PettyCashVoucher::class, PettyCashTransaction::class);


        return [
            'accounts' => [
                'grossTransaction' => GrossVoucherTransaction::collection(
                    $this->grossVoucherTransaction()->get()->keyBy('type')
                ),
                'dailyTransaction' => GrossVoucherTransaction::collection(
                    $this->grossVoucherTransaction()
                        ->whereDate('transactions.created_at', date('Y-m-d'))
                        ->get()->keyBy('type')
                ),

                'monthlyTransaction' => GrossVoucherTransaction::collection(
                    $this->grossVoucherTransaction()
                        ->whereMonth('transactions.created_at', date('n'))
                        ->whereYear('transactions.created_at', date('Y'))
                        ->get()->keyBy('type')
                ),

                'totalVoucherAmount' => TotalVoucherAmount::collection($this->totalVoucherAmount()),
                'availablePettyCash' => $pettyCashDeposit - $pettyCashExpense,
                'advancePayment' => (float)$this->advancePaymentAmount()->amount,

                'todayIncome' => (float)$this->dailyAccountStatus('income'),
                'todayExpense' => (float)$this->dailyAccountStatus('expense'),
                'monthlyIncome' => (float)$this->monthlyAccountStatus('income'),
                'monthlyExpense' => (float)$this->monthlyAccountStatus('expense')
            ],
        ];
    }




    public function grossVoucherTransaction()
    {
        return Transaction::query()
        ->where('transactions.company_id', company_id())
        ->selectRaw('sum(transactions.amount) as amount, vouchers.type')
        ->join('voucher_sector_payments', function (JoinClause $join){
            $join->on('transactions.transactionable_id', '=', 'voucher_sector_payments.id')
                ->where('transactions.transactionable_type', VoucherSectorPayment::class);
        })->join('vouchers', function (JoinClause $joinClause){
            $joinClause->on('voucher_sector_payments.voucher_id','=', 'vouchers.id')
                ->where('vouchers.company_id', company_id());
        })
        ->groupBy('vouchers.type');
    }

    public function totalVoucherAmount()
    {
        return TotalVoucherAmount::collection(
            Voucher::selectRaw('sum(amount) as amount, type')
            ->where('company_id', company_id())
            ->groupBy('type')
            ->get()
            ->keyBy('type')
        );
    }

    private function getGrossIncome($model, $table = Transaction::class)
    {
        return $table::where('company_id', company_id())
            ->where('transactionable_type', $model)
            ->sum('amount');
    }

    private function dailyAccountStatus($type)
    {
        return Transaction::where('company_id', company_id())
            ->whereIn('transactionable_type', $this->transactionableModels($type))
            ->whereDate('created_at', date('Y-m-d'))
            ->sum('amount');
    }
    private function monthlyAccountStatus($type)
    {
        return Transaction::where('company_id', company_id())
            ->whereIn('transactionable_type', $this->transactionableModels($type))
            ->whereMonth('created_at', date('n'))
            ->whereYear('created_at', date('Y'))
            ->sum('amount');
    }

    public function transactionableModels($type = 'expense')
    {
        if ($type == 'income'){
            return [
                InventoryProductSale::class
            ];
        }

        return [
            PettyCashDeposit::class,
            InventoryProductPurchase::class
        ];
    }

    public function advancePaymentAmount()
    {
        return Transaction::query()
            ->selectRaw('ABS(sum(transactions.amount)) as amount')
            ->join('voucher_sector_payments', function (JoinClause $join){
                $join->on('transactions.transactionable_id', '=', 'voucher_sector_payments.id')
                    ->where('transactions.transactionable_type', VoucherSectorPayment::class);
            })
            ->join('vouchers', function (JoinClause $joinClause){
                $joinClause->on('voucher_sector_payments.voucher_id','=', 'vouchers.id')
                    ->where('vouchers.company_id', company_id())
                    ->where('vouchers.type', 'debit')
                    ->where('vouchers.payment_type', 'advance');
            })
            ->first();
    }
}
