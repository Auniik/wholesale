<?php

namespace App\Http\Controllers;

use App\Models\PaymentSector;
use Illuminate\Http\Request;
use Validator;
use Auth;

class PaymentSectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:account-settings-list')->only('index');
        $this->middleware('permission:account-settings-create')->only('create', 'store');
        $this->middleware('permission:account-settings-update')->only('edit', 'update');
        $this->middleware('permission:account-settings-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('generalAccount.sector.index', [
            'allData' => PaymentSector::query()
                ->where('fk_company_id',company_id())
                ->orderBy('id','desc')->paginate()
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
        $validator = Validator::make($request->all(),[
            'sector_name' => 'required',
            'type' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();
        $input['created_by'] = Auth::user()->id;
        $input['updated_by'] = Auth::user()->id;
        $input['fk_company_id'] = auth()->user()->fk_company_id;
        try {
            PaymentSector::create($input);

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success',' Data Created Successfully.');
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

        $getAccount = PaymentSector::findOrFail($id);
        /*validator required file about us page*/
        $validator = Validator::make($request->all(),[
            'sector_name' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();

        try {
            $input['updated_by']=Auth::user()->id;
            $getAccount->update($input);/*update data*/
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Data Updated Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
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
        $getAccount = PaymentSector::findOrFail($id);

        try {
            $getAccount->delete();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Data Deleted Successfully ');
        }else{
            return redirect()->back()->with('error','Error : '.$bug1);
        }
    }

    public function load_sector(Request $request){
        $paymentSector = PaymentSector::query()
            ->select('sector_name', 'id')
            ->where([['fk_company_id', auth()->user()->fk_company_id],['status', 1]])
            ->where('sector_name', 'LIKE', "%{$request->query('name')}%");
        if ($request->type == 'debit'){
            return response()->json($paymentSector->where('type', 1)->get());
        }
        if ($request->type == 'credit'){
            return response()->json($paymentSector->where('type', 2)->get());
        }


    }
}
