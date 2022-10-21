@extends('layouts.newlayout')
@section('content')

<div class="d-flex justify-content-between my-2">
    <h2>Location</h2>
</div>
  
  <table class="table rounded border">                                                                                                                                
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">email</th>
          <th scope="col">Address</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($locations as $location)
          <tr>
          <th scope="row">{{$loop->iteration}}</th>
          <td>{{$location->name}}</td>
          <td>{{$location->email}}</td>
          <td>{{$location->address}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$locations->links()}}


@stop
