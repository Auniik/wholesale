<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AccountPaymentMethod;
use App\Models\AccountSetting;
use Validator;
use Auth;

class AccountPaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:account-settings-list')->only('index');
        $this->middleware('can:account-settings-create')->only('create', 'store');
        $this->middleware('can:account-settings-update')->only('edit', 'update');
        $this->middleware('can:account-settings-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allData = AccountPaymentMethod::where('fk_company_id',Auth::user()->fk_company_id)->orderBy('id','desc')->get();
        $account_info = AccountSetting::where('fk_company_id',Auth::user()->fk_company_id)->where('status','1')->orderBy('id','asc')->get();
        return view('account.paymentMethod', compact('allData','account_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'method_name' => 'required',
                'fk_account_id' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();
        
        // echo "<pre>";
        // print_r($input);exit;

        $input['created_by'] = Auth::user()->id;
        $input['updated_by'] = Auth::user()->id;
        $input['fk_company_id'] = Auth::user()->fk_company_id;
        AccountPaymentMethod::create($input);
        return back()->with('success','Success fully added');
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
         $getMethodData = AccountPaymentMethod::findOrFail($id);
        /*validator required file about us page*/
        $validator = Validator::make($request->all(),[
            'fk_account_id' => 'required',
            'method_name' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();
        
        try {
            $input['updated_by']=Auth::user()->id;
            $getMethodData->update($input);/*update data*/
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }
       
        if($bug == 0){
            return redirect()->back()->with('success','Payment Method Updated Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getMethodData = AccountPaymentMethod::findOrFail($id);
        
        try {
            $getMethodData->delete();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }
       
        if($bug == 0){
            return redirect('payment-method')->with('success','Delete payment method item Successfully ');
        }else{
            return redirect('payment-method')->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }

    public function getMethods(Request $request){
        return AccountPaymentMethod::where('fk_account_id', $request->id)->get();

    }
}
