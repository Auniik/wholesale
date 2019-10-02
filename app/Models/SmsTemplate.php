<?php

namespace App\Models;

use App\Traits\AddingCompany;
use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    use AddingCompany;

    protected $fillable = [
        'outdoor', 'daily_expense_report', 'company_id', 'created_by', 'updated_by'
    ];



    public function totalExpense($company_id)
    {
        $todayReport = new AccountDashboard();
        $today_transaction = $todayReport->voucherTransaction($company_id)
            ->whereDate('transactions.created_at', date('Y-m-d'))
            ->get()
            ->keyBy('type');


        $todayExpense = $todayReport->dailyMonthlyAccountStatus('expense', true, $company_id);

        $debit_voucher_expense = array_get($today_transaction->get('debit'), 'amount', 0);

        return number_format(abs($todayExpense + $debit_voucher_expense), 2);
    }


    public function totalDue()
    {

    }

    public function expenseSmsTemplate($company_id)
    {
        return str_replace([
            '{EXPENSE_AMOUNT}',
            '{CURRENT_DUES}',
            '{DATE}',
        ], [
            $this->totalExpense($company_id),
            0,
            date('d/m/Y')
        ], $this->daily_expense_report);
    }


    public function outdoorConfirmation($appointment)
    {
        return str_replace([
            '{DOCTOR_NAME}',
            '{DATE}',
            '{SCHEDULE}',
        ], [
            $appointment->doctor->user->name,
            $appointment->date->format('j M'),
            $appointment->schedule
        ], $this->outdoor);
    }



}
