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

@php
    $currentUser = Auth::user()
@endphp
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
@section('content')
<div id="content-header">
<h1>{{ trans('profile.showProfileTitle',['username' => $user->first_name]) }}</h1>

</div>
   
<div class="container-fluid">
  <hr>
  <div class="row-fluid" style="margin-left:150px;">
    <div class="span7">
      <div class="widget-box">
        <div class="widget-content nopadding">

        @if($user->profile==null)
                                                    <img src="https://png.pngtree.com/png-vector/20190710/ourmid/pngtree-user-vector-avatar-png-image_1541962.jpg"  style="width: 150px;height: 150px;
 border:1px solid black;
 border-radius:50%;
 margin-left:35%;
 margin-top:5%;">
                                                     @else
                                                    <img style="width: 150px;
 height: 150px;
 border:1px solid black;
 border-radius:50%;
 margin-left:35%;
 margin-top:5%;"
                                                        src="{{asset($user->profile->public_path)}}" alt="profile">
                                                   
                                                @endif
  <br>
  <br>
                    <div class="control-group" style="margin-left:20%;">
             <div class="row">
             <div class="col-md-1" style="float:left"></div>
                 <div class="col-md-5" style="float:left">User Name</div>
                 <div class="col-md-5">{{$user->name}}</div>
                 <div class="col-md-1" style="float:left"></div>

            </div>
            <br>
            <div class="row">
             <div class="col-md-1" style="float:left"></div>
                 <div class="col-md-5" style="float:left">First Name</div>
                 <div class="col-md-5">{{$user->first_name}}</div>
                 <div class="col-md-1" style="float:left"></div>

            </div>
            <br>
            <div class="row">
             <div class="col-md-1" style="float:left"></div>
                 <div class="col-md-5" style="float:left">Last Name</div>
                 <div class="col-md-5">{{$user->last_name}}</div>
                 <div class="col-md-1" style="float:left"></div>

            </div>
            <br>
            <div class="row">
             <div class="col-md-1" style="float:left"></div>
                 <div class="col-md-5" style="float:left">Email</div>
                 <div class="col-md-5">{{$user->email}}</div>
                 <div class="col-md-1" style="float:left"></div>

            </div>
            <br>
            <div class="row">
             <div class="col-md-1" style="float:left"></div>
                 <div class="col-md-5" style="float:left"></div>
                 <div class="col-md-5"> @if ($currentUser->id == $user->id)
                                {!! HTML::icon_link(URL::to('/profile/'.$currentUser->id.'/edit'), 'fa fa-fw fa-cog', trans('titles.editProfile'), array('class' => 'btn btn-small btn-info btn-block')) !!}
                            @endif</div>
                 <div class="col-md-1" style="float:left"></div>

            </div>
                       
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>

@endsection

