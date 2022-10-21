<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use App\Models\Business;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class LocationController extends Controller
{
    public function index(){
        $user = Sentinel::getUser(); 
        $locations = Location::where('user_id','=',$user->id)->with(['business'])->paginate(5);
        $businesses = Business::where('user_id','=',$user->id)->get();
       return view('pages.location.location',compact('locations','businesses','user'));
    }

    public function store(Request $request){
      $user = Sentinel::getUser(); 
      if(!$user->hasAccess(['location.create'])){
         Session::flash('message', 'You can not cerate Location');
         Session::flash('alert-class','alert-danger');
         return redirect()->route('location.index');
      }
        $request->validate([
           'email' => 'required',
           'name' => 'required',
           'address' => 'required|min:10',
       ]);  
           $email = array($request->email);
           $rules = array('email' => 'unique:businesses,email');
           $validator = Validator::make($email,$rules);
           
           if (Location::where('email', '=',$request->email)->count() > 0) {
            Session::flash('message', 'Email Already Registered');
            Session::flash('alert-class','alert-danger');
           return back()->withInput();  
        
           }else{

           $location = new Location();
           $location->name = $request->name;
           $location->email = $request->email;
           $location->address = $request->address;
           $location->business_id = $request->business_id;
           $location->user_id = Sentinel::getUser()->id;
           $location->save();
  
           Session::flash('message', 'Location Add Successfully');
           Session::flash('alert-class', 'alert-success');
           return redirect()->route('location.index');
  
       }
      }

      public function edit($id){
        $user = Sentinel::getUser(); 
        $location =  Location::find($id);
        
        if($location->user_id != $user->id){
         Session::flash('message', 'You connot Access other User\'s Businesses');
         Session::flash('alert-class','alert-danger');
         return redirect()->route('location.index');
        }

        if(!$user->hasAccess(['location.edit'])){
         Session::flash('message', 'You can not Edit Location');
         Session::flash('alert-class','alert-danger');
         return redirect()->route('location.index');
         }

        $businesses = Business::where('user_id', '=', $user->id)->get();
        return view('pages.location.edit',compact('location','businesses'));

    }


    public function update(Request $request,$id){
           $data = $request->except('_method','_token','submit');
        
        $validator = Validator::make($request->all(), [
           'name' => 'required|string|min:3',
           'email' => 'required|email|min:3',
        ]);
        
        if ($validator->fails()) {
           return redirect()->back()->withInput()->withErrors($validator);
        }
  
        $location = Location::find($id);
        info([$data,$location]);
        if($location->email != $request->email && Location::where('email', '=',$request->email)->count() > 0){ 
            Session::flash('message', 'Email Already Registered');
            Session::flash('alert-class','alert-danger');
            return back()->withInput();
        }
         if($location->update($data)){
           Session::flash('message', 'Location Update successfully!');
           Session::flash('alert-class', 'alert-success');
           return redirect()->route('location.index');
        }else{
           Session::flash('message', 'Data not updated!');
           Session::flash('alert-class', 'alert-danger');
           return redirect()->route('location.index');
        }
  
        return back()->withInput();
     }
  
     public function delete(Request $request){

      $user = Sentinel::getUser(); 

        $id = $request->id;
        $location =  Location::find($id);
        $location->delete();
    
    }

  
}
