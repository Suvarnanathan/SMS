@extends('layouts.admin')
@section('content')
<div id="content-header">
  <h3>SHOW ALL  PARTICIPANTS</h3>
</div>
<br>
<div class="container-fluid"> 
 <button type="button" style="margin-left:90%"class="btn btn-primary"><a style="color:white"href="/participated-sports/create">Add New</a></button>
</div>
<br>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col">Field Events</th>
      <th scope="col">Track Events</th>
      <th scope="col">Action</th>


    </tr>
  </thead>
  <tbody>
  @foreach($users as $user)                  
  @if($user->events->count() > 0)
  <tr>
      <th scope="row">{{$user->first_name}}</th>
      <td>{{$user->last_name}}</td>
      <td>{{$user->email}}</td>
      <td>

      @foreach($user->events as $event)
      {{$event->event_category=='Field events'?$event->event_name:' '}}

    @endforeach
</td>
<td>
                @foreach($user->events as $event)     
{{$event->event_category=='Track events'?$event->event_name :' '}}
@endforeach
</td>
<td><button type="button" class="btn btn-info"><a style="color:white"href="{{ URL::to('/participated-sports/'.$user->id.'/edit') }}">Edit</a></button></td>
@endif
@endforeach
</tr>

  </tbody>
</table>
@endsection