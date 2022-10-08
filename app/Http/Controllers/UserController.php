<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function check(Request $request){
        
        $email = $request->email;
        $pass = $request->password;
        

        if(auth()->attempt(array('email'=>$email,'password'=>$pass))){
            $user_mail = Auth::user()->email;  
            session(['usrmail' => $user_mail]);
            return redirect('/dashboard');
        }
        else{  
            session()->flash('error', 'Invalid Email or/and Password'); 
            return back()->withInput();
        }  
    }

    public function store(Request $request){

        // Validate Inputs
        $validateData = $request->validate([
            'name' => 'required|regex:/^[a-z A-Z]+$/u',
            'email' => 'required|email',
            'password' => 'required|min:6|max:12',
        ]);

        //Validate Unique Email from database
        
        $email = array($request->email);
        $pass = $request->password;
        $rules = array('email' => 'unique:users,email');
        $validator = Validator::make($email,$rules);

        if ($validator->fails()) {
            $request->session()->flash('register_status','This Email already exists.');
            return redirect('/login');
        }
        else{
            $User = new User;
            $User->name = $request->name;
            $User->email = $request->email;
            $User->password = Hash::make($request->password);
            $User->save();
            
            
            auth()->attempt(array('email'=>$email,'password'=>$pass));
            $request->session()->flash('register_status','User has been registered successfully');
            $user_mail = Auth::user()->email;  
            session(['usrmail' => $user_mail]);
            return redirect('/dashboard');
        }
    }

}
