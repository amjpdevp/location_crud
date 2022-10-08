<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Business;


class BusinessController extends Controller
{
    //

    public function index(){
        $user_id = Auth::user()->id; 
        $businesses = Business::where('user_id', '=', $user_id)->with('locations')->paginate(5);     
         return view('pages.business.business',compact('businesses'));
    }

    public function store(Request $request){

      $request->validate([
         'email' => 'required',
         'name' => 'required',
         'address' => 'required|min:10',
     ]);
         $email = array($request->email);
         $rules = array('email' => 'unique:businesses,email');
         $validator = Validator::make($email,$rules);
         
         if (Business::where('email','=',$request->email)->count() > 0) {

         Session::flash('message', 'Email Already Registered');
         Session::flash('alert-class','alert-danger');
         return Back()->withInput();   
         }else{
         $business = new Business;
         $business->name = $request->name;
         $business->email = $request->email;
         $business->address = $request->address;
         $business->user_id = Auth::user()->id;
         $business->save();

         Session::flash('message', 'Business Register Successfully');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('business.index');

     }

    }

    public function edit($id){
        $Business =  Business::find($id);
        return view('pages.business.edit',compact('Business'));
    }
    


    public function update(Request $request,$id){
     
         $data = $request->except('_method','_token','submit');
      
      $validator = Validator::make($request->all(), [
         'name' => 'required|string|min:3',
         'email' => 'required|email|min:3',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }

      $business = Business::find($id);
      info([$data,$business]);
      if($business->update($data)){
         Session::flash('message', 'Update successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('business.index');
      }else{
         Session::flash('message', 'Data not updated!');
         Session::flash('alert-class', 'alert-danger');
      }

      return Back()->withInput();
   }

   public function Delete(Request $request){
      $id = $request->id;
      $Business =  Business::find($id);
      $Business->delete();
  
  }
}




