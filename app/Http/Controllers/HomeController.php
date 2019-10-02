<?php

namespace App\Http\Controllers;

use App\Models\SubMenu;
use Illuminate\Http\Request;

use App\Models\PrimaryInfo;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $info=PrimaryInfo::first();
        \Session::put('title_msg',$info->company_name);
        \Session::put('metaDescription',$info->short_description);
        \Session::forget('keywords');
        return view('index',compact('info'));
    }

    public function subMenu($id){

        $subMenu = SubMenu::where(['status'=>1,'fk_menu_id'=>$id])->limit(7)->orderBy('serial_num','ASC')->get();
        \Session::put('menu',$id);
        return view('_partials.subMenu',compact('subMenu'));
    }
    
    public function about(){
        $info=PrimaryInfo::first();
        \Session::put('title_msg','About us');
        \Session::put('metaDescription',$info->short_description);
        \Session::forget('keywords');
        return view('frontend.about',compact('info'));
    }    


    public function home()
    {
        return view('layout.app');
    }


}
