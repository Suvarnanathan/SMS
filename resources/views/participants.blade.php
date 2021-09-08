@extends('layouts.admin')
@section('content')
<div id="content-header">
  <h3>SHOW ALL  PARTICIPANTS</h3>
</div>
<br>
<div class="container-fluid"> 
 <button type="button" style="margin-left:90%"class="btn btn-primary"><a style="color:white"href="/participated-sports/create">Add New</a></button>
 <br>
 <input type="checkbox" name="checkall" class="checkall">
 <a href="#" id="deleteSelectedRow"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg></a>
</div>
<br>
<table class="table table-bordered">
  <thead>
    <tr>
      <th></th>
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
  <tr id="userId{{$user->id}}">
    <td><input type="checkbox" name="deletechk" class="deletechk" value="{{$user->id}}"></td>
      <td scope="row">{{$user->first_name}}</td>
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
<span>{{$users->links()}}</span>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
   $(".checkall").click(function() {
  $(".deletechk").prop("checked", this.checked);
});

$("#deleteSelectedRow").click(function(e){
  e.preventDefault();
  var ids=[];
  $("input:checkbox[name=deletechk]:checked").each(function(){
    ids.push($(this).val());
  });

  $.ajax({
    url:"{{route('user.deleteChecked')}}",
    type:"DELETE",
    data:{
      '_token': '{{ csrf_token() }}',
            allids:ids
    },
    success:function(response){
      $.each(ids,function(key,val){
        $("#userId"+val).remove();
      })

    }
  });
});
</script>
@endsection
