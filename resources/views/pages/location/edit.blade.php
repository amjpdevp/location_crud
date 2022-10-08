@extends('layouts.newlayout')
@section('content')

<form class="mx-5 mt-3 p-5 border rounded pt-3" action="{{ route('location.update',[$location->id])}}" method="POST">
    @method('put')  
    @csrf
    <h2>Edit Location</h2>
    <label for="business">Business</label>
    <select class="form-select" name="business_id" id="business" aria-label="Default select example">
        @foreach ($businesses as $business)                  
        <option value="{{$business->id}}" @if($business->id == $location->business_id)
          Selected
          @endif>
        {{$business->name}}
        </option>  
        @endforeach
      </select>
    <div class="form-group my-3">
        <label for="InputName">Name</label>
        <input type="text" class="form-control" id="InputName" name="name" value="{{$location->name}}">
      </div>
<div class="form-group my-3">
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{$location->email}}">
</div>
  <div class="form-group">
    <label for="InputAddress">Address</label>
    <input type="text" class="form-control" id="InputAddress" rows="2" name="address" value="{{$location->address}}" >
  </div>
  <button type="submit" class="btn btn-primary rounded my-3">Update</button>
  @if(Session::has('message'))
<div class="alert {{ Session::get('alert-class') }}">
   {{ Session::get('message') }}
</div>
@endif
</form>
@stop
