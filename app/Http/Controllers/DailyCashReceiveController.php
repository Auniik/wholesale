<?php

namespace App\Http\Controllers;

use App\Models\Accounts\Transaction;
use App\Models\DoctorAppointment;
use App\Models\HospitalServiceSale;
use App\Models\IndoorPatientBooking;
use App\Models\Patient;
use App\Models\ServiceCategory;
use function foo\func;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DailyCashReceiveController extends Controller
{
    public function index(Request $request)
    {
//        $patients = Patient::with('todayOutdoor','todayIndoor', 'todayPatientServices')
//            ->where('patients.company_id', company_id())
//            ->orderBy('patients.id', 'ASC')
//            ->get();

        return view('report.cash-receive.index', [
            'company' => auth()->user()->companyInfo,
//            'patients' => $patients,
//            'serviceCategories' => ServiceCategory::where('status', 1)->get()
        ]);
    }
}
