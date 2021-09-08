@extends('layouts.admin')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
<div id="content-header">
  <h3>ADD PARTICIPATE SPORTS</h3>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid" style="margin-left:150px;">
    <div class="span8">
      <div class="widget-box">
        <div class="widget-content nopadding">
          <form  method="POST" action="{{route('events.store')}}"class="form-horizontal">
          @csrf
          <div class="control-group" id="append">
              <div>
              <label style="margin-left:20px;">EventCategory: </label>
              <input type="text" name="eventCategory[]"/>
              <label>Event Name :</label>
              <input type="text" name="eventName[]"/>
              <button type="button" class="btn btn-success" id="add">+</button>

              </div>

            </div>

            
<div>
            <div class="form-actions">
              <button type="submit" style="margin-left:200px;"class="btn btn-success">Save</button>
            </div>
          </form>
        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
  var i=1;
$('#add').click(function(){
    i++;
    $('#append').append('<div id="row'+i+'"><label style="margin-left:20px;">EventCategory: </label><input type="text" name="eventCategory[]"/><label>Event Name :</label><input type="text" name="eventName[]"/><button type="button" class="btn btn-danger remove" id="'+i+'">-</button></div></div>')

});
$(document).on('click','.remove',function(){
var row_id=$(this).attr("id");
$('#row'+row_id+'').remove();
});

</script>
@endsection