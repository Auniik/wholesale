<?php

namespace App\Http\Controllers;

use App\Http\Requests\SMS\SMSRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\InventorySupplier;
use App\Models\Party;
use App\Models\Patient;
use App\Models\ReportSmsableNumber;
use App\Models\SmsConfig;
use App\Models\SmsGroup;
use App\Models\SmsTemplate;
use Illuminate\Http\Request;
use App\Services\SMS\Facades\SMS;
use Illuminate\Support\Facades\Crypt;
use View;

class SmsController extends Controller
{


    public function index()
    {
        return view('sms.sendsms.index',[
            'sms_groups' => SmsGroup::get(['id','group_name','numbers']),
            'sms_config' => SmsConfig::where('company_id', company_id())->first(),
            'departments' => Department::with('company')->get(['id','name']),
            'template' => SmsTemplate::where('company_id', company_id())->first(),
            'reportableNumbers' => ReportSmsableNumber::where('company_id', company_id())->first()
        ]);
    }


    public function sendSms(SMSRequest $request)
    {
        $request->configCheckAndSend($request->numbers, $request->message);

        return back()->with('success','SMS sent successfully');


    }

    public function getEmployee(Request $request){
        $employees = Employee::orderBy('id','desc')->where('company_id',auth()->user()->fk_company_id)->where('status',1);

        if($request->filled('department_id')){
            $employees->whereDepartment_id($request->department_id);
        }
        return view('sms.sendsms.ajax_employee',[
            'employees' => $employees->get()
        ]);
    }

    public function getParties(Request $request){
        $parties = Party::where('company_id', company_id());
        if ($request->filled('status')){
            /** @var Party $parties */
            $parties->whereStatus($request->status);
        }
        return view('sms.sendsms.ajax_parties',[
            'parties' => $parties->get()
        ]);
    }


    public function getGroupNumbers($id){
        if ($id){
            return SmsGroup::Company()->find($id)->numbers;
        }
        return '';
    }
    public function getPatientType(Request $request){
        if ($request->query('type')){
            $patients =  Patient::where('type', $request->get('type'))->whereNotNull('mobile_number');
            return view('sms.sendsms.ajax_patients',[
                'patients' => $patients->get()
            ]);
        }
        return '';
    }
}
