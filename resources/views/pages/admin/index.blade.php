
@extends('layouts.newlayout')
@section('content')
<div class="d-flex justify-content-between my-2">
  <h2>Users</h2>
</div>
@csrf
<table class="table rounded border                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">First name</th>
        <th scope="col">Last Name</th>
        <th scope="col">E-mail</th>
        <th scope="col">Role</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        
        @foreach ($users as $user)
        {{--dd($user->roles[0]->name)--}}
      <tr id="{{$user->id}}">
        <th scope="row">{{$user->id}}</th>
        <td>{{$user->first_name}}</td>
        <td>{{$user->last_name}}</td>
        <td>{{$user->email}}</td>
        <td>
            {{$user->roles[0]->name}}
        </td>
        <td>
            <a href="{{ route('user.edit',[$user->id]) }}"><button type="button" class="btn btn-primary rounded" onclick=EditBusiness($this)>Edit</button></a>
            <button type="button" class="btn btn-danger rounded " onclick="deleteuser({{$user->id}})" >Delete</button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{$users->links()}}
@stop