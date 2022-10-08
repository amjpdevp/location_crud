@extends('layouts.newlayout')
@section('content')
<div class="d-flex justify-content-between my-2">
  <h2>Users</h2> 
</div>
<table class="table rounded border                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">E-mail</th>
        <th scope="col">Registered at</th>
      </tr>
    </thead>
    <tbody>
        
        @foreach ($users as $user)
      <tr>
        <th scope="row">{{$user->id}}</th>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->created_at}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{$users->links()}}
@stop