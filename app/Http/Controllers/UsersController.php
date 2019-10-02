<?php

namespace App\Http\Controllers;

use App\Models\CompanyList;
use App\Models\Role;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Hash;
use App\Rules\OldPassword;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user-list')->only('index');
        $this->middleware('can:user-create')->only('store', 'create');
        $this->middleware('can:user-update')->only('update', 'edit');
        $this->middleware('can:user-delete')->only('destroy');
        $this->middleware('can:user-view')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $allUsers = User::with('roles')->where('email','!=','admin@smartsoft.com')->where('fk_company_id', company_id())->orderBy('id','DESC')->paginate(20);
        $allUsers = User::with('role')
            ->where('email','!=','admin@smartsoft.com')
            ->orderBy('id','DESC');

        if ($request->filled('name')){
            $allUsers->where('name', 'LIKE', "%{$request->name}%");
        }
        if ($request->filled('role_id')){
            $allUsers->where('id', $request->role_id);
        }

        $roles = Role::where('name','!=','System Admin')->get();

        return view('user.index',compact('roles'), [
            'allUsers' => $allUsers->paginate()
        ]);
    }

    /**
     * Show the form for creating a new Admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name', '<>', 'System Admin')->get();
        $company = CompanyList::where('status',1)->pluck('company_name','id');
        return view('user.create', compact('company', 'roles'));
    }

    /**
     * Store a newly created Admin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
           'name' => 'required|max:20',
           'role_id' => 'required',
           'fk_company_id' => 'required',
           'email' => 'email|required|unique:users',
           'password' => 'required|min:6|confirmed',
       ]);
                
            $input = $request->all();
            $input['password']=bcrypt($input['password']);
            $input['created_by']=Auth::user()->id;
            $input['status'] = 1;
            $user = User::create($input);
//            $user->giveRoleTo($request->role);

            return back()->with('success','Data Successfully Inserted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $data=User::findOrFail($id);
//        $roles=DB::table('roles')->where('system',1)->pluck('name','id');
//        $company=CompanyList::where('status',1)->pluck('company_name','id');
//        return view('user.show',compact('data','roles','company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $data=User::findOrFail($id);
//        return view('user.password',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return $request->all();
        $user = User::find($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'email|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();
        $user->update($input);

        return back()->withSuccess('User Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function destroy($id)
    {
    /** @var User $data */
        $data = User::findOrFail($id);
        try {
           $data->delete();
        } catch (\Exception $e) {
            return back()->with('error', 'This is not deletable user');
        }
        return back()->with('success','Data has been Successfully Deleted!');
    }


    public function profile(){
        $id=Auth::user()->id;
        $data=User::findOrFail($id);
        $type=DB::table('user_type')->where('type',Auth::user()->type)->pluck('type_name','type');
        return view('profile.show',compact('data','type'));
    }

        // public function changePass()
        // {
        //     $id=Auth::user()->id;
        //     $data=User::findOrFail($id);
        //     return view('profile.password',compact('data'));
        // }

    public function changePass(Request $request, User $user)
    {
        $request->validate([
            'old_password' => ['required', new OldPassword($user)],
            'password' => 'required_with:password|min:6|different:old_password|confirmed',
        ]);

        $update_pass = $user->update([
            'password'=>bcrypt($request->password),
        ]);

    
        return back()->with('success','Password Changed Successfully'); 
        
    }
}
