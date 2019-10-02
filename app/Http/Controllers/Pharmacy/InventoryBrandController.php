<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryBrand;
use Validator;

class InventoryBrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:inventory-settings-list')->only('index');
        $this->middleware('can:inventory-settings-create')->only('store', 'create');
        $this->middleware('can:inventory-settings-update')->only('update', 'edit');
        $this->middleware('can:inventory-settings-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $brands = InventoryBrand::orderBy('id','desc')->where('company_id',\Auth::user()->fk_company_id)->paginate();
        return view('pharmacy.inventory.brand.index', compact('brands'));
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
        $validator = Validator::make($request->all(),[
                'name' => 'required'
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        InventoryBrand::create($request->all());
        return back()->withSuccess('Brand added successfully!');
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
        $brand = InventoryBrand::findOrFail($id);
        $validator = Validator::make($request->all(),[
                'name' => 'required'

        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $brand->update($request->all());
        return back()->withSuccess('Brand Updated!');
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getBrand = InventoryBrand::findOrFail($id);
        
        try {
            $getBrand->delete();
            
            $bug = 0;
            
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }
        
        if($bug == 0){
            return redirect("inventory-brand")->with('success','Brand Deleted Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }
}
