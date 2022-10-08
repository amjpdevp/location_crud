<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use App\Models\Business;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class LocationController extends Controller
{
    public function index(){
        $user_id = Auth::user()->id; 
        $locations = Location::where('user_id','=',$user_id)->with(['business'])->paginate(5);
        $businesses = Business::where('user_id','=',$user_id)->get();
       return view('pages.location.location',compact('locations','businesses'));
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
           $location->user_id = Auth::user()->id;
           $location->save();
  
           Session::flash('message', 'Location Add Successfully');
           Session::flash('alert-class', 'alert-success');
           return redirect()->route('location.index');
  
       }
      }

      public function edit($id){
        $user_id = Auth::user()->id; 
        $location =  Location::find($id);
        
        if($location->user_id != $user_id){
         Session::flash('message', 'You connot Edit other User\'s Businesses ');
         Session::flash('alert-class','alert-danger');
         return redirect()->route('location.index');
        }
        $businesses = Business::where('user_id', '=', $user_id)->get();
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
        $id = $request->id;
        $location =  Location::find($id);
        $location->delete();
    
    }

  
}
