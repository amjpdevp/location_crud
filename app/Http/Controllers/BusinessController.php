<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use App\Models\Business;
use App\Models\Location;


class BusinessController extends Controller
{
    //

    public function index(){
      $user = Sentinel::getUser(); 
      $businesses = Business::where('user_id', '=', $user->id)->with('locations')->paginate(5); 
      return view('pages.business.business',compact('businesses','user'));
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
         $business->user_id = Sentinel::getUser()->id;
         $business->save();

         Session::flash('message', 'Business Register Successfully');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('business.index');

     }

    }

    public function edit($id){

      $user = Sentinel::getUser(); 
      $business =  Business::find($id);
      
      if($business->user_id != $user->id){

       Session::flash('message', 'You connot Edit other User\'s Businesses ');
       Session::flash('alert-class','alert-danger');
       return redirect()->route('business.index');

      }

        $Business =  Business::find($id);
        return view('pages.business.edit',compact('Business'));

    }
    


    public function update(Request $request,$id){
      
      $user = Sentinel::getUser(); 

      if(!$user->hasAccess(['business.edit'])){
         Session::flash('message', 'You Don\'t have access For edit businesses');
         Session::flash('alert-class','alert-danger');
         return redirect()->route('business.index');
      }

      $data = $request->except('_method','_token','submit');
      
      $validator = Validator::make($request->all(), [
         'name' => 'required|string|min:3',
         'email' => 'required|email|min:3',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }

      $business = Business::find($id);
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
   public function view(Request $request,$id){
      $user = Sentinel::getUser(); 
      $locations = Location::where('business_id','=',$id)->paginate(5);
      return view('pages.business.location',compact('locations'));
   }

   public function Delete(Request $request){
      
      $user = Sentinel::getUser(); 
      if(!$user->hasAccess(['business.delete'])){
         Session::flash('message', 'You Don\'t have access For Delete businesses');
         Session::flash('alert-class','alert-danger');
      }

      $id = $request->id;
      $Business =  Business::find($id);
      $Business->delete();
  
  }
}




