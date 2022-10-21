@extends('layouts.newlayout')
@section('content')
@if(Session::has('message'))
<div class="alert w-50 {{ Session::get('alert-class') }}" id="msg">
   {{ Session::get('message') }}
   <script>
    setTimeout(() => {
      $("#msg").remove();
    },2000);
   </script>
</div>
@endif
<div class="d-flex justify-content-between my-2">
    <h2>Your Branches  </h2>
    @if($user->hasAccess(['location.create']))
    <button type="button" class="btn btn-primary rounded" data-toggle="modal" data-target="#exampleModal" >Add New Location</button>
    @endif
  </div>
  
  <table class="table rounded border">                                                                                                                                
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">email</th>
          <th scope="col">Business</th>
          <th scope="col">Address</th>
          @if($user->hasAccess(['location.edit']) || $user->hasAccess(['location.delete']))
          <th scope="col">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        
        
        @foreach ($locations as $location)
        @empty($location)
        <tr><td>Record Not Found</td></tr>
        @endempty
        <tr id="{{$location->id}}">
          <th scope="row">{{$loop->iteration}}</th>
          <td>{{$location->name}}</td>
          <td>{{$location->email}}</td>
          <td>{{$location->business->name}}</td>
          <td>{{$location->address}}</td>
          <td>
            @if($user->hasAccess(['location.edit']))
            <a href="{{ route('location.edit',[$location->id]) }}"><button type="button" class="btn btn-primary rounded px-5">Edit</button></a>
            @endif
            @if($user->hasAccess(['location.delete']))
            <button type="button" class="btn btn-danger rounded px-5" onclick='Deletelocation(this)'>Delete</button>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
      @csrf
    </table>
    {{$locations->links()}}

  
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New Location Add</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('location.store')}}" method="post">
                @csrf
                <select class="form-select py-2" name="business_id" aria-label="Default select example">
                  <option selected>Select Business</option>
                  @foreach ($businesses as $business)                  
                  <option value="{{$business->id}}">{{$business->name}}</option>  
                  @endforeach
                </select>
                <div class="form-group py-2">
                    <input type="text" class="form-control" name="name" placeholder="Location Name" required="required">
                </div>
                <div class="form-group py-2">
                    <input type="email" class="form-control" name="email" placeholder="Location e-mail" required="required">
                </div>
                <div class="form-group py-2">
                    <input type="text" class="form-control" name="address" placeholder="Address" required="required">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
          
          </form>
          </div>
        </div>
      </div>
     
      @error('address')
      <div class="alert alert-danger">{{ $message }}</div>
      @enderror
  @stop