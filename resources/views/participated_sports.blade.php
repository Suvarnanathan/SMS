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
          <form  method="POST" action="{{route('participated-sports.store')}}"class="form-horizontal">
          @csrf
          <div class="control-group">
              <div >
              <label style="margin-left:20px;">Participants: </label>
              <select class="span11"name="userId" id="userId">
              <option disabled selected>Select participant</option>
              @foreach($users as $user)
  <option value="{{$user->id}}">{{$user->first_name}}</option>
  @endforeach

                </select>
                </div>
                </div>
          <div class="control-group">
              <div style="padding:20px;">
              <label>Track Events :</label>
              @foreach($trackEvents as $trackEvent)
              {{ $trackEvent->event_name }} &nbsp; <input type="checkbox" name="events[]" value="{{ $trackEvent->id }}">
@endforeach 
              </div>
            </div>
            <div class="control-group">
              <div style="padding:20px;">
              <label>Field Events :</label>
              @foreach($fieldEvents as $fieldEvent)
              {{ $fieldEvent->event_name }} &nbsp; <input type="checkbox" name="events2[]" value="{{ $fieldEvent->id }}">
@endforeach 
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
   
var $checkboxes = $("input[name='events[]']");

$checkboxes.change(function () {
    if (this.checked) {
    $a=$("input[name='events2[]']").filter(':checked').length;
    $b=$checkboxes.filter(':checked').length;
        if ($checkboxes.filter(':checked').length == 2) {
            $checkboxes.not(':checked').prop('disabled', true);
        }
    } 
    // else if($(this).not(':checked'))
    // {
    //   $checkboxes.not(':checked').prop('disabled', false);

    // }
    else {
        $checkboxes.prop('disabled', false);
    }

    if($a==1 && $b==2){
    $('input[type=checkbox]').not(':checked').attr("disabled","disabled");
    }
    if($a==2 && $b==1){
    $('input[type=checkbox]').not(':checked').attr("disabled","disabled");
    }
});

var $checks = $("input[name='events2[]']");

$checks.change(function () {
    if (this.checked) {
    $a=$("input[name='events[]']").filter(':checked').length;
    $b=$checks.filter(':checked').length;
    if ($checks.filter(':checked').length == 2) {
            $checks.not(':checked').prop('disabled', true);
        }
    }
     else {
        $checks.prop('disabled', false);
    }
    if($a==1 && $b==2){
    $('input[type=checkbox]').not(':checked').attr("disabled","disabled");
    }
    if($a==2 && $b==1){
    $('input[type=checkbox]').not(':checked').attr("disabled","disabled");
    }
});

</script>
@endsection