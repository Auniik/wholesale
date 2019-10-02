<?php

namespace App\Console\Commands;

use App\Http\Controllers\SmsConfigController;
use App\Http\Requests\SMS\SMSRequest;
use App\Models\AccountDashboard;
use App\Models\CompanyList;
use App\Models\ReportSmsableNumber;
use App\Models\SmsTemplate;
use App\User;
use Illuminate\Console\Command;

class SmsDailyReport extends Command
{
    public $user;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendsms:expense_report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Expense report every night at 11:59PM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (CompanyList::all() as $company){

//            $numbers = ReportSmsableNumber::where('company_id', $company->id)->first()->numbers;
            $template = SmsTemplate::where('company_id', $company->id)->first();
            $sendReport = new SMSRequest();
            $sendReport->configCheckAndSend($numbers, $template->expenseSmsTemplate($company->id), $company->id);

            echo 'Send Successfully!';
        }

    }

}
