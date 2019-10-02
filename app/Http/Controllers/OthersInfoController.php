<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Models\PrimaryInfo;

class OthersInfoController extends Controller
{

    /**
     * Display Video Section Information.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=PrimaryInfo::first();
        return view('othersInfo.primaryInfo',compact('data'));
    }

    /**
     * Show Section Contact photo.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Change Video section information, contact section photo and body parallax Background
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display Body Parallax Photo background.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data=PrimaryInfo::first();
        return view('othersInfo.about',compact('data'));
    }

    /**
     * Show Organization primary information.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Display About Company.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update Primary info and about company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $data=PrimaryInfo::findOrFail($request->id);

        $validator = Validator::make($input, [

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('logo')) {
            $photo=$request->file('logo');
            $path=base_path().'/images/logo';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(186,60);
            $img->save('images/logo/logo.png');
            $input['logo']='images/logo/logo.png';
        }
        if ($request->hasFile('favicon')) {
            $photo=$request->file('favicon');
            $path=base_path().'/images/logo';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(50,50);
            $img->save('images/logo/favicon.png');
            $input['favicon']='images/logo/favicon.png';
        }

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
        //
    }
}
