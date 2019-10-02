<?php

namespace App\Http\Controllers;


use App\Rules\OldPassword;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(){

    	return view('profile.index');
    }


    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'. auth()->id() .',id',
            'address' => '',
        ]);
        $user = auth()->user();
        /** @var User $user */
        $user->update($attributes);
    	return back()->withSuccess('Profile Updated Successfully!');
    }


    public function changePass(Request $request){
        $request->validate([
            'old_password' => ['required', new OldPassword($request->user())],
            'password' => 'required_with:password|min:6|different:old_password|confirmed',
        ]);

        $update_pass = User::find(auth()->user()->id)->update([
            'password'=>bcrypt($request->password),
        ]);

        if ($update_pass){
            return redirect()->back()->with('success','Password Changed Successfully');
        }else{
            return redirect()->back()->with('error','Sorry! Cant not change password this time.');
        }
    }



}
