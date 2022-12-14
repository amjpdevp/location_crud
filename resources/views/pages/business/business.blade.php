@extends('layouts.newlayout')
@section('content')

<div class="d-flex justify-content-between my-2">
  
  <h2>Your Company</h2>
  @if($user->hasAccess(['business.create']))
  <button type="button" class="btn btn-primary rounded ms-2" data-toggle="modal" data-target="#exampleModal" >Register New Company</button>
  @endif
</div>
<table class="table rounded border w-100">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">email</th>
        <th scope="col">Address</th>
        
        @if($user->hasAccess(['business.edit']) || $user->hasAccess(['business.delete']))
        <th scope="col">Actions</th>
        @endif
      </tr>
    </thead>
    <tbody>
        
        @foreach ($businesses as $business)
      <tr id="{{$business->id}}">
        <th scope="row">{{$loop->iteration}}</th>
        <td>{{$business->name}}</td>
        <td>{{$business->email}}</td>
        <td>{{$business->address}}</td>
        <td>
          <a href="{{ route('business.location.view',[$business->id]) }}"><button type="button" class="btn btn-primary rounded" >View</button></a>
          @if($user->hasAccess(['business.edit']))
          <a href="{{ route('business.edit',[$business->id]) }}"><button type="button" class="btn btn-warning rounded" onclick=EditBusiness($this)>Edit</button></a>
          @endif
          @if($user->hasAccess(['business.delete']))
          <button type="button" class="btn btn-danger rounded " onclick='DeleteBusiness(this)'>Delete</button>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
    @csrf
  </table>
  {{$businesses->links()}}
  @error('address')
    <div class="alert alert-danger">{{ $message }}</div>
  @enderror
  @if(Session::has('message'))
      <div class="alert {{ Session::get('alert-class') }}">
         {{ Session::get('message') }}
      </div>
    @endif

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New Company Registration</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <form action="{{route('business.store')}}" method="post">
              @csrf
              <div class="form-group py-2">
                  <input type="text" class="form-control" name="name" placeholder="New Company Name" required="required">
              </div>
              <div class="form-group py-2">
                  <input type="email" class="form-control" name="email" placeholder="Company e-mail" required="required">
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
    </div>
   
    
@stop