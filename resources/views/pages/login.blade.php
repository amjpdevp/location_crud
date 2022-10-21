@extends('layouts.newlayout',['noNav' => true])

@section('content')
    <div class="login-form">
            <form  action="{{ route('login.auth') }}" method="POST">
            @csrf
            <h2 class="text-center py-2">Log in</h2>       
            <div class="form-group py-2">
                <input type="text" class="form-control" name="email" placeholder="E-mail" required="required">
            </div>
            <div class="form-group py-2">
                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
            <div class="form-group py-2">
                <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </div>
            @if(Session::has('error'))
            <div class="alert alert-danger">
               {{ Session::get('error') }}
            </div>
            @endif
                
        </form>
        <div class="text-center"><a href="#"><button type="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">Create New Account</button></a></div>

        <!-- Button trigger modal -->
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('user.store')}}" method="post">
            @csrf
            <div class="form-group py-2">
                <input type="text" class="form-control" name="firstname" placeholder="Enter Your First Name" required="required">
            </div>
            <div class="form-group py-2">
              <input type="text" class="form-control" name="lastname" placeholder="Enter Your Last Name" required="required">
          </div>
            <div class="form-group py-2">
                <input type="email" class="form-control" name="email" placeholder="Enter Your E-mail" required="required">
            </div>
            <div class="form-group py-2">
                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
        @error('email')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </form>
      </div>
    </div>
  </div>
    </div>

  @stop



