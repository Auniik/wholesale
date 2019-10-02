<?php

namespace App\Http\Requests\Reports;

use App\Models\Accounts\Transaction;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherSectorPayment;
use App\Models\DoctorAppointment;
use App\Models\HospitalServiceSale;
use App\Models\IndoorPatientBooking;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class CashCollection extends FormRequest
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

    protected function startDate()
    {
        return $this->fromDate ?? date('Y-m-d');
    }
    protected function endDate()
    {
        return $this->toDate ?? date('Y-m-d');
    }

    public function todayCollection($model)
    {
        return Transaction::with('createdBy')
            ->where([['transactionable_type', $model],['company_id', company_id()]])
            ->selectRaw("sum(transactions.amount) as income, created_by")
            ->whereBetween(DB::raw('DATE(transactions.created_at)'), [$this->startDate(), $this->endDate()])
            ->groupBy('created_by')
            ->get();
    }


    public function voucherCollection()
    {
        return Transaction::with('createdBy')
            ->where([['transactionable_type', VoucherSectorPayment::class],['transactions.company_id', company_id()]])
            ->whereBetween('transactions.created_at', [$this->startDate(), $this->endDate()])
            ->selectRaw("sum(transactions.amount) as income, transactions.created_by")
            ->join('voucher_sector_payments', function (JoinClause $joinClause){
                $joinClause->on('voucher_sector_payments.id','=','transactions.transactionable_id');
            })
            ->join('vouchers', function (JoinClause $joinClause){
                $joinClause->on('voucher_sector_payments.voucher_id','=','vouchers.id')
                ->where('vouchers.type', 'credit');
            })
            ->groupBy('created_by')
            ->get();
    }
}
