<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    public function check(Request $request){
        
        $email = $request->email;
        $pass = $request->password;
        
        $credentials = [
            'email'    => $email,
            'password' => $pass,
        ];

        $user = Sentinel::findByCredentials($credentials);
        if(Sentinel::authenticate($credentials)){
            return redirect('dashboard');
        }
        else {  
            session()->flash('error', 'Invalid Email or/and Password'); 
            return back()->withInput();
        }  
    }

    public function dashboard(){

        $users = User::where('is_admin','=',0)->with('roles')->paginate(5);
        if(Sentinel::getUser()->is_admin){
            return view('pages.admin.index',compact('users'));
        }
        else{
            return view('pages.user',compact('users'));
        }
        
        
    }


    public function store(Request $request){

        $first_name = $request->firstname;
        $last_name = $request->lastname;
        
        // Validate Inputs
        $validateData = $request->validate([
            'firstname' => 'required|regex:/^[a-z A-Z]+$/u',
            'email' => 'required|email',
            'password' => 'required|min:6|max:12',
        ]);

        //Validate Unique Email from database
        $email = $request->email;
        $pass = $request->password;
        $rules = array('email' => 'unique:users,email');
        $validator = Validator::make([$email],$rules);

        if ($validator  ->fails()) {
            $request->session()->flash('register_status','This Email already exists.');
            return redirect('/login');
        }
        else{

            $credentials = [
                'email'    => $email,
                'password' => $pass,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'is_admin' => '0',  
            ];
            $user = Sentinel::registerAndActivate($credentials);
            $user = Sentinel::loginAndRemember($user);
            $role = Sentinel::findRoleByName('operator');
            $role->users()->attach($user);

            Session::flash('message', "Welcome! $first_name");
            Session::flash('alert-class','alert-success');

            return redirect('/dashboard');
        }
    }

        public function edit($id){
        $accessbyuser = Sentinel::getUser(); 

        
        $user = Sentinel::findById($id);
        $roles = config('app.roles');
        return view('pages.admin.edit',compact('user','roles'));
    }

    public function update(Request $request,$id){

        $user = Sentinel::findById($id);

        if($user->email != $request->email && user::where('email','=',$request->email)->count() > 0){ 
            Session::flash('message', 'Email Already Registered');
            Session::flash('alert-class','alert-danger');
            return back()->withInput();
        }
        
        $credentials = [
            'email' => $request->email,
            'first_name' => $request->fname,
            'last_name' => $request->lname,
        ];

        Sentinel::update($user, $credentials);

        $permissions = [
            'business.create' => false,
            'business.edit' => false,
            'business.delete' => false,
            'location.create' => false,
            'location.edit' => false,
            'location.delete' => false
        ];
        // dd($request->perms);
        foreach($permissions as $permission => $value){
            if ($request->perms !=null && in_array($permission,$request->perms))
                {
                    $permissions[$permission] = true;
                }
           
        }
        $user->permissions = $permissions;
        $user->save();  
      
        if($user->roles[0]->name != $request->role){
            //detach role
             $role = Sentinel::findRoleByName($user->roles[0]->name);
             $role->users()->detach($user);
            //attach new role
            $role = Sentinel::findRoleByName($request->role);
            $role->users()->attach($user);
        }

        Session::flash('message', 'User Updated Succesfully');
        Session::flash('alert-class','alert-success');
        return back()->withInput();

    }

    public function delete(Request $request){

        $loginUser = Sentinel::getUser($request->id);

        if (!$loginUser->hasAccess(['user.delete'])){
            Session::flash('message', 'You Does not have Permission To Delete Users');
            Session::flash('alert-class','alert-danger');
        }

        $id = $request->id;
        $user = Sentinel::findById($id);
        $user->delete();
    
    }

    public function logout(){
        $user = Sentinel::getUser();
        Sentinel::logout($user);
        return redirect('/login');
    }

}
