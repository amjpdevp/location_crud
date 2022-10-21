@extends('layouts.newlayout')
@section('content')

<h4 class="mx-5">Edit User : {{$user->first_name}}</h4>    
<form class="mx-5 mt-3 p-3 border rounded" action="{{ route('user.update',[$user->id])}}" method="POST">
    @method('put')
    @csrf
    <div class="form-group my-3">
        <label for="InputFirstName">First name</label>
        <input type="text" class="form-control" id="InputFirstName" name="fname" value="{{$user->first_name}}">
    </div>
    <div class="form-group my-3">
        <label for="InputLastName">last name</label>
        <input type="text" class="form-control" id="InputLastName" name="lname" value="{{$user->last_name}}">
    </div>
<div class="form-group my-3">
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{$user->email}}">
</div>

<label for="InputRole">Role</label>
<select class="form-select" id="InputRole" name='role' aria-label="Default select example">
   
@foreach($roles as $role)
<option value="{{$role}}" @if($role == $user->roles[0]->name) Selected @endif >{{$role}}</option>
@endforeach
</select>

<div class="form-group my-3">
     
    <label for="exampleInputEmail1">For Businesses</label>
        <div class="form-check">
            <input class="form-check-input " type="checkbox" value="business.create" name="perms[]" @if($user->hasAccess(['business.create'])) checked @endif>
            <label class="form-check-label" for="flexCheckDefault">Create</label>
        </div>
        <div class="form-check">
            <input class="form-check-input " type="checkbox" value="business.edit" name="perms[]"  @if($user->hasAccess(['business.edit'])) checked @endif>
            <label class="form-check-label" for="flexCheckDefault">Edit</label>
        </div>
        <div class="form-check">
            <input class="form-check-input " type="checkbox" value="business.delete" name="perms[]"  @if($user->hasAccess(['business.delete'])) checked @endif>
            <label class="form-check-label" for="flexCheckDefault">Delete</label>
        </div>
    <br>
    
    <label for="exampleInputEmail1">For Locations</label>
        <div class="form-check">
            <input class="form-check-input " type="checkbox" value="location.create" name="perms[]"  @if($user->hasAccess(['location.create'])) checked @endif>
            <label class="form-check-label" for="flexCheckDefault">Create</label>
        </div>
        <div class="form-check">
            <input class="form-check-input " id="location.edit" type="checkbox" value="location.edit" name="perms[]"  @if($user->hasAccess(['location.edit'])) checked @endif >
            <label class="form-check-label" for="flexCheckDefault">Edit</label>
        </div>
        <div class="form-check">
            <input class="form-check-input " type="checkbox" value="location.delete" name="perms[]"  @if($user->hasAccess(['location.delete'])) checked @endif>
            <label class="form-check-label" for="flexCheckDefault">Delete</label>
        </div>
  <button type="submit" class="btn btn-primary rounded my-3">Update</button>
</form>

@if(Session::has('message'))
      <div class="alert {{ Session::get('alert-class') }}">
         {{ Session::get('message') }}
      </div>
    @endif  
@stop
