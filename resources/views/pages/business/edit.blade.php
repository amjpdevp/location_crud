@extends('layouts.newlayout')
@section('content')


<form class="mx-5 mt-3 p-3 border rounded" action="{{ route('business.update',[$Business->id])}}" method="POST">
    @method('put')
    @csrf
    <div class="form-group my-3">
        <label for="InputName">Name</label>
        <input type="text" class="form-control" id="InputName" name="name" value="{{$Business->name}}">
      </div>
<div class="form-group my-3">
    <label for="exampleInputEmail1">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{$Business->email}}">
</div>
  <div class="form-group">
    <label for="InputAddress">Address</label>
    <input type="text" class="form-control" id="InputAddress" rows="2" name="address" value="{{$Business->address}}" >
  </div>

  <button type="submit" class="btn btn-primary rounded my-3">Update</button>
</form>
@stop
