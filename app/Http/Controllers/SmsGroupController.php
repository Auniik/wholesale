<?php

namespace App\Http\Controllers;

use App\Models\SmsGroup;
use Illuminate\Http\Request;

class SmsGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:sms-group-list')->only('index');
        $this->middleware('can:sms-group-create')->only('create', 'store');
        $this->middleware('can:sms-group-update')->only('update', 'edit');
        $this->middleware('can:sms-group-destroy')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = SmsGroup::orderBy('id','desc')->paginate(20);
        return view('sms.groupsms.index',compact('groups'));
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

         $request->validate([
            'group_name' => 'required|unique:sms_groups',
            'csv_file'   => 'required|file'
        ]);

        $numbers = [];
        $csv_file = fopen($request->file('csv_file')->getRealPath(),'r');
        while ($row = fgetcsv($csv_file)){
            $rowNumbers = [];
            foreach ($row as $rowNumber){
                array_push($rowNumbers, ('0'.ltrim($rowNumber,'0')));
            }
            array_push($numbers,implode(',',$rowNumbers));
        }
        SmsGroup::create([
            'group_name' => $request->group_name,
            'numbers' => implode(',',$numbers),
        ]);
        return back()->with('success','New group created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SmsGroup  $smsGroup
     * @return \Illuminate\Http\Response
     */
    public function show(SmsGroup $smsGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SmsGroup  $smsGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsGroup $smsGroup)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SmsGroup  $smsGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsGroup $smsGroup)
    {
        $data = $request->validate([
            'group_name' => 'required',
            'numbers'    => 'required',
        ]);
        $smsGroup->update($data);
        return back()->with('success','Information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmsGroup  $smsGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsGroup $smsGroup)
    {
        $smsGroup->delete();
        return back()->with('success','Data deleted successfully');
    }
}
