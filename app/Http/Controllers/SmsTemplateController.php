<?php

namespace App\Http\Controllers;

use App\Models\SmsTemplate;
use Illuminate\Http\Request;
use Validator;
use Session;

class SmsTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:sms-template-list')->only('index');
        $this->middleware('can:sms-template-create')->only('store');
        $this->middleware('can:sms-template-update')->only('update');
        $this->middleware('can:sms-template-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $template = SmsTemplate::where('company_id', company_id())->first();


        return view('sms.template.index', compact('template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SmsTemplate::create($request->all());
        return back()->withSuccess('Template Updated Successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SmsTemplate  $smsTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(SmsTemplate $smsTemplate)
    {
        //
    }
//    public function findTemplate($id){
//        $message = SmsTemplate::find($id);
//        return $message;
//    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SmsTemplate  $smsTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsTemplate $smsTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SmsTemplate  $smsTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsTemplate $smsTemplate)
    {
        $smsTemplate->update($request->all());
        return back()->withSuccess('SMS Template updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmsTemplate  $smsTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsTemplate $smsTemplate)
    {
        try {
            $smsTemplate->delete();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return back()->with('success','Area Deleted Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }
}
