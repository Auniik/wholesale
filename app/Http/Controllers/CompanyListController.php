<?php

namespace App\Http\Controllers;

use App\Models\CompanyList;
use App\Models\CompanyBank;
use App\Models\IndustryType;
use Illuminate\Http\Request;
use Validator;

class   CompanyListController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:company-list')->only('index');
        $this->middleware('can:company-create')->only('store', 'create');
        $this->middleware('can:company-update')->only('update', 'edit');
        $this->middleware('can:company-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = CompanyList::orderBy('id','DESC')->paginate(20);
        return view('company.index',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $type = IndustryType::all();
        return view('company.create',[
//            'type'=>$type
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'company_name'=>'required',
            'logo'=>'required',
            'address'=>'required',
//            'shipping_address'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('logo')) {
            $photo=$request->file('logo');
            $ext= $photo->getClientOriginalExtension();
            $name = date('Ymdhis').rand(1,100).$ext;
            $path=base_path().'/images/company';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(186,60);
            $img->save('images/company/'.$name);
            $input['logo']='images/company/'.$name;
        }
        if ($request->hasFile('favicon')) {
            $photo=$request->file('favicon');
            $ext= $photo->getClientOriginalExtension();
            $name = date('Ymdhis').rand(1,100).'.'.$ext;
            $path=base_path().'/images/company';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(50,50);
            $img->save('images/company/'.$name);
            $input['favicon']='images/company/'.$name;
        }
        $company_id = CompanyList::create($input)->id;
        // company bank
//        for ($i=0;$i<sizeOf($request->bank_name);$i++)
//        {
//            CompanyBank::create([
//                'company_id' => $company_id,
//                'bank_name' => $input['bank_name'][$i],
//                'account_name' => $input['account_name'][$i],
//                'branch_name' => $input['branch_name'][$i],
//                'SWIFT' => $input['SWIFT'][$i],
//                'routing_number' => $input['routing_number'][$i],
//                'opening_balance' => $input['opening_balance'][$i],
//            ]);
//        }

        try{
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return back()->with('success','Data Successfully Inserted');
        }else{
            return back()->with('error','Something Error Found ! ');
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
        $data = CompanyList::with('bank')->findOrFail($id);
        return view('company.edit', compact('data'));
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
        $input = $request->all();
        $data=CompanyList::findOrFail($request->id);

        $validator = Validator::make($input, [
//             'company_name'=>'required',
            'address'=>'required',
//            'shipping_address'=>'required',
            'mobile_no'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('logo')) {
            $photo=$request->file('logo');
            $ext= $photo->getClientOriginalExtension();
            $name = date('Ymdhis').rand(1,100).'.'.$ext;
            $path=base_path().'/images/company';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(186,60);
            $img->save('images/company/'.$name);
            $input['logo']='images/company/'.$name;
            if($data->logo!=null and file_exists($data->logo)){
                unlink($data->logo);
            }
        }
        if ($request->hasFile('favicon')) {
            $photo=$request->file('favicon');
            $ext= $photo->getClientOriginalExtension();
                $name = date('Ymdhis').rand(1,100).$ext;
            $path=base_path().'/images/company';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(50,50);
            $img->save('images/company/'.$name);
            $input['favicon']='images/company/'.$name;
            if($data->favicon!=null and file_exists($data->favicon)){
                unlink($data->favicon);
            }
        }
//        if (isset($input['bank_id'])) {
//            for ($i = 0; $i < sizeof($input['old_bank_name']); $i++) {
//                $update = CompanyBank::find($input['bank_id'][$i])->update([
//                    'bank_name'         => $input['old_bank_name'][$i],
//                    'account_name'      => $input['old_account_name'][$i],
//                    'branch_name'       => $input['old_branch_name'][$i],
//                    'SWIFT'             => $input['old_SWIFT'][$i],
//                    'routing_number'    => $input['old_routing_number'][$i],
//                    'opening_balance'   => $input['opening_balance'][$i],
//                ]);
//            }
//        }
//        if (isset($input['bank_name'])) {
//            for ($j=0;$j<sizeOf($request->bank_name);$j++)
//            {
//                CompanyBank::create([
//                    'company_id'        => $id,
//                    'bank_name'         => $input['bank_name'][$j],
//                    'account_name'      => $input['account_name'][$j],
//                    'branch_name'       => $input['branch_name'][$j],
//                    'SWIFT'             => $input['SWIFT'][$j],
//                    'routing_number'    => $input['routing_number'][$j]
//                ]);
//            }
//        }

        try{

            $data->update($input);

            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Successfully Update');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
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
        $data=CompanyList::findOrFail($id);
        try{
            if($data->logo!=null and file_exists($data->logo)){
                unlink($data->logo);
            }
            if($data->favicon!=null and file_exists($data->favicon)){
                unlink($data->favicon);
            }
            $data->delete();
            $bug=0;
            $error=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            $error=$e->errorInfo[2];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }elseif($bug==1451){
            return redirect()->back()->with('error','This Data is Used anywhere ! ');

        }
        elseif($bug>0){
            return redirect()->back()->with('error','Some thing error found !');

        }
    }
}
