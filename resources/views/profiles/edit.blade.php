@extends('layouts.adminlayout.admin_design')

@section('template_title')
    {{ $user->name }}'s Profile
@endsection

@section('template_fastload_css')
    #map-canvas{
        min-height: 300px;
        height: 100%;
        width: 100%;
    }
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
@php
    $currentUser = Auth::user()
@endphp
<style>
    input[type='file'] {
  color: transparent;
}
</style>
@section('content')
<div id="content-header">
<h1>Edit User Deatils of {{$user->first_name }}</h1>

</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid" style="margin-left:150px;">
    <div class="span7">
      <div class="widget-box">
        <div class="widget-content nopadding">
  <br>
  <br>
  <form  method="post" action="/profile/{{$user->id}}/update" enctype="multipart/form-data" class="form-horizontal">
  @csrf
                @method('put') 
                <div class="row">
                <div class="col-1">
                </div>
                <div class="col-10">
                @if($user->profile==null)<input id="upload" class="file-upload__input" type="file"
                                                            name="image" onchange="readURL(this);">
                                                            <img src="https://png.pngtree.com/png-vector/20190710/ourmid/pngtree-user-vector-avatar-png-image_1541962.jpg" id="productImage" style="border-radius: 50%; width:150px;height:150px"/>

                                                     @else
                                                            <input id="upload" class="file-upload__input" type="file"
                                                            name="image" onchange="readURL(this);">
                                                            <img src="{{asset($user->profile->public_path)}}" id="productImage" style="border-radius: 50%; width:150px;height:150px"/>
                                                            @endif
                                                            </div>
                <div class="col-1">
            </div>
        </div>        
        <div class="row">
                <div class="col-1">
                </div>
                <div class="col-10">
                     <label class="control-label">User Name :</label><br><br>
                     <input type="text" value="{{$user->name}}"style="margin-left:95px;
                        padding: 10px 0;" class="span8" placeholder="Book Name" name="name" disabled/>
                </div>
                <div class="col-1">
            </div>
        </div>
        <div class="row">
                <div class="col-1">
                </div>
                <div class="col-10">
              <label class="control-label">Email Addre:</label><br><br>
                <input type="text" value="{{$user->email}}"style="margin-left:95px;
    padding: 10px 0;" class="span8" placeholder="Book Name" name="email" disabled/>
  
            </div>
            <div class="col-1">
            </div>
        </div>
        <div class="row">
                <div class="col-1">
                </div>
                <div class="col-10">             
                     <label class="control-label">First Name :</label><br><br>
                <input type="text" style="margin-left:95px;
    padding: 10px 0;" class="span8" placeholder="Book Name" name="first_name" value="{{$user->first_name}}"/>
     </div>
            <div class="col-1">
            </div>
        </div>
        <div class="row">
                <div class="col-1">
                </div>
                <div class="col-10">               <label class="control-label">Last Name :</label><br><br>
                <input type="text" style="margin-left:95px;
    padding: 10px 0;" class="span8" placeholder="Book Name" name="last_name" value="{{$user->last_name}}"/>
     <div class="col-1">
            </div>
        </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary" style="float:right;">Update</button>
            </div>
          </form>  
                                        
                                </div>
                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

@endsection
<script>
        function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#productImage')
            .attr('src', e.target.result)
           
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    </script>