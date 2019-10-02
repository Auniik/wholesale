<?php

namespace App\Http\Controllers;

use App\Models\CompanyList;
use App\Models\SmsConfig;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Crypt;

class SmsConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sms.config.index',[
            'smsConfigs' => SmsConfig::paginate(),
            'companies' => CompanyList::pluck('company_name', 'id')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function create()
    {
        $test = Auth::user()->id;
        dd($test);
        return $test;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'masking_name' => 'required',
            'user_name' => 'required',
            'user_password' => 'required',
            'sms_quantity' => 'required',
            'company_id' => 'required|unique:sms_configs',
        ]);
        $data['masking_name'] = encrypt($request->masking_name);
        $data['user_name'] = encrypt($request->user_name);
        $data['user_password'] = encrypt($request->user_password);
        $data['sms_quantity'] = encrypt($request->sms_quantity);
        $data['company_id'] = $request->company_id;

        SmsConfig::create($data);


        return back()->withSuccess('SMS Configuration Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SmsConfig $smsConfig
     * @return void
     */
    public function destroy(SmsConfig $smsConfig)
    {
        $smsConfig->delete();
        return response([
            'check' => true
        ]);
    }

}
