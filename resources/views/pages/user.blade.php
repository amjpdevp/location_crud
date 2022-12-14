@extends('layouts.newlayout')
@section('content')
<div class="d-flex justify-content-between my-2">
  <h2>Users</h2> 
</div>
<table class="table rounded border                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">E-mail</th>
        <th scope="col">Registered at</th>
      </tr>
    </thead>
    <tbody>
        
        @foreach ($users as $user)
      <tr>
        <th scope="row">{{$user->id}}</th>
        <td>{{$user->first_name}}</td>
        <td>{{$user->last_name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->created_at}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{$users->links()}}
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
@stop