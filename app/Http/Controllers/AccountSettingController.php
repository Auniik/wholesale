<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AccountSetting;

use Validator;
use Auth;

class AccountSettingController extends Controller
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
        return view('account.index', [
            'accounts' => AccountSetting::where('fk_company_id', company_id())
                ->orderByDesc('id')
                ->paginate(),
            'default_account' => defaultAccount(),
        ]);

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

        $request->validate([
            'account_name' => 'required',
            'opening_balance' => 'required'
        ]);


        $input = $request->all();

        $input['current_balance'] = $request->opening_balance;
        if($request->filled('default_status')){
            if ($status = AccountSetting::where('default_status', 1)->first()) $status->update(['default_status' => 0]);
            $input['default_status'] = 1;
        };

        try {
            $account = AccountSetting::with('transaction')->create($input);
            $account->transaction()->create([
                'account_id' => $account->id,
                'amount' => $request->opening_balance
            ]);

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success',' New Account Created Successfully.');
        }else{
            return redirect()->back()->with('error',' Error : '.$bug1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Account Balance


    }

    public function getAccountBalance($id)
    {
        return AccountSetting::where('id',$id)->value('current_balance');
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
        $account = AccountSetting::find($id);
        $input =  $request->all();
//        dd($input);

        /*validator required file about us page*/
        $validator = Validator::make($request->all(),[
            'account_name' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if(!$request->filled('default_status')){
            $default_status = 0;
        }else{
            $defaultAccount = AccountSetting::where('default_status', 1)->first();
            if ($defaultAccount){
                $defaultAccount->update(['default_status' => 0]);
            }
            $default_status = 1;
        }
        try {
            $account->update([
                'account_no' => $request->account_no,
                'account_name' => $request->account_name,
                'branch_name' => $request->branch_name,
                'status' => $request->status,
                'default_status' => $default_status
            ]); /*update data*/
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return back()->withSuccess('Account Updated Successfully.');
        }else{
            return back()->with('error','Error: '.$bug1);
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
        $account = AccountSetting::findOrFail($id);
        $account->transaction->delete();


        try {
            $account->delete();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Data Deleted Successfully ');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }
}
