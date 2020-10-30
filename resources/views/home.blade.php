@extends('layouts.app')

@section('content')

<div class="top-heading">

@if ($message = Session::get('success'))
<div class="alert alert-dismissible alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Well done!</strong>{{ $message }}.
</div>
@endif

<div class="row">


<div class="col-md-3 dashboard-wrapper">
<div class="panel panel-default">
  <div class="panel-body">
  <div class="row dashboard-panel">
  <div class="col-md-12" style="padding-top: 10px;">
<a href="{{url('users/'.Auth::user()->id.'/edit')}}">
  <img class="img-responsive img-asset" src="{{asset('img/padlock.png')}}">
  <p class="text-center">Change Password</p>
</a>
  </div>
  </div>
  </div>
</div>
</div>


<div class="col-md-3 dashboard-wrapper">
<div class="panel panel-default">
  <div class="panel-body">
  <div class="row dashboard-panel">
  <div class="col-md-12" style="padding-top: 10px;">
<a href="{{ url('employees/'.Auth::user()->employees->id.'/edit') }}">
  <img class="img-responsive img-asset" src="{{asset('img/customer-service.png')}}">
  <p class="text-center">Update Information</p>
</a>
  </div>
  </div>
  </div>
</div>
</div>


<div class="col-md-3 dashboard-wrapper">
<div class="panel panel-default">
  <div class="panel-body">
  <div class="row dashboard-panel">
  <div class="col-md-12" style="padding-top: 10px;">
<a href="#">
  <img class="img-responsive img-asset" src="{{asset('img/help.png')}}">
  <p class="text-center">Call Support <em>2121</em></p>
</a>
  </div>
  </div>
  </div>
</div>
</div>



</div>


</div><!-- end top header -->


@endsection
