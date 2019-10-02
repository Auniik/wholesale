<?php

namespace App\Http\Controllers;

use App\Models\ReportSmsableNumber;
use Illuminate\Http\Request;

class ReportSmsableNumberController extends Controller
{
    public function report(Request $request)
    {
        $report = ReportSmsableNumber::where('company_id', company_id())->first();
        if ($report){
            return $this->update($request);
        }
        return $this->store($request);
    }


    public function store(Request $request)
    {
        ReportSmsableNumber::create($request->all());
        return back()->withSuccess('Numbers Added Successfully!');
    }

    public function update($request)
    {
        $reportSmsableNumber = ReportSmsableNumber::where('company_id', company_id())->first();
        $reportSmsableNumber->update($request->all());
        return back()->withSuccess('Numbers Updated Successfully!');
    }
}
