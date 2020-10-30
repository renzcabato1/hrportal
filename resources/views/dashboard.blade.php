@extends('layouts.app')

@section('content')

<div class="top-heading">
<div class="row">

<div class="col-md-3 dashboard-wrapper">
<div class="panel panel-default">
  <div class="panel-body">
  <div class="row dashboard-panel">
  <div class="col-md-4" style="padding-top: 10px;">
  <i class="pe-7s-server"></i>
  </div>
  <div class="col-md-8 dashboard-panel-title">
   <p>
   Employees
   </p>
    <span style="font-family: 'Source Sans Pro', sans-serif;  font-weight: 200; font-size: 50px;">
    {{$total_employees->count()}}
   </span>
  </div>
  </div>
  </div>
  <div class="panel-footer">
  <p>
    <i class="pe-7s-clock"></i>  Last updated: Today
  </p>
  </div>
</div>
</div>

<div class="col-md-3 dashboard-wrapper">
<div class="panel panel-default">
  <div class="panel-body">
  <div class="row dashboard-panel">
  <div class="col-md-4" style="padding-top: 10px;">
  <i class="pe-7s-add-user"></i>
  </div>
  <div class="col-md-8 dashboard-panel-title">
   <p>
   New Employees
   </p>
    <span style="font-family: 'Source Sans Pro', sans-serif;  font-weight: 200; font-size: 50px;">
    {{$new_hire->count()}}
   </span>
  </div>
  </div>
  </div>
  <div class="panel-footer">
  <p>
    <i class="pe-7s-clock"></i>  Last updated: Today
  </p>
  </div>
</div>
</div>

<div class="col-md-3 dashboard-wrapper">
<div class="panel panel-default">
  <div class="panel-body">
  <div class="row dashboard-panel">
  <div class="col-md-4" style="padding-top: 10px;">
  <i class="pe-7s-delete-user"></i>
  </div>
  <div class="col-md-8 dashboard-panel-title">
   <p>
   Total Inactive
   </p>
    <span style="font-family: 'Source Sans Pro', sans-serif;  font-weight: 200; font-size: 50px;">
   {{$tota_inactive->count()}}
   </span>
  </div>
  </div>
  </div>
  <div class="panel-footer">
  <p>
    <i class="pe-7s-clock"></i>  Last updated: Today
  </p>
  </div>
</div>
</div>


<div class="col-md-3 dashboard-wrapper">
<div class="panel panel-default">
  <div class="panel-body">
  <div class="row dashboard-panel">
  <div class="col-md-4" style="padding-top: 10px;">
  <i class="pe-7s-bell"></i>
  </div>
  <div class="col-md-8 dashboard-panel-title">
   <p>
  Total Update
   </p>
    <span style="font-family: 'Source Sans Pro', sans-serif;  font-weight: 200; font-size: 50px;">
    {{$total_update->count()}}
   </span>
  </div>
  </div>
  </div>
  <div class="panel-footer">
  <p>
  <a href="{{url('/totalUpdate')}}">
    <i class="pe-7s-clock"></i> View Details
  </a>
  </p>
  </div>
</div>
</div>

</div> <!--- end row -->


<div class="row">
<div class="col-md-6">


<div class="panel panel-default">
  <div class="panel-heading">
       <div class="header">
          <h4 class="title">
          New Hire Employees</h4>
          <p class="category">As of this month: {{ date('F, Y', strtotime( Carbon\Carbon::now())) }}</p>


      </div>
  </div>
  <div class="panel-body table-panel">
  <table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th></th>
      <th>ID</th>
      <th>Name</th>
      <th>Company</th>
   <!--    <th>Date Hired</th> -->
    </tr>
  </thead>
  <tbody>
@foreach($employees as $employee)
  <tr>
    <td>
      <img class="img-responsive" src="{{asset('img/avatar.png')}}" style="width: auto; height: 30px;">
    </td>
    <td>{{ $employee->id }}</td>
    <td>{{ $employee->full_name }}</td>
    <td>{{$employee->company}}</td>
  <!--   <td>{{date('F d, Y', strtotime($employee->date_hired))}}</td>  -->
  </tr>
@endforeach
  </tbody>
</table> 
  </div>

</div><!-- end panel -->


</div><!-- end col-md-8 -->

<div class="col-md-6">


<div class="panel panel-default">
  <div class="panel-heading">
       <div class="header">
          <h4 class="title">
          Employee's Remarks</h4>
          <p class="category">As of this month: {{ date('F, Y', strtotime( Carbon\Carbon::now())) }}</p>


      </div>
  </div>
  <div class="panel-body table-panel">
  <table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th></th>
      <th>Name</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
@forelse($remarks as $remark)
  <tr>
    <td>
      <img class="img-responsive" src="{{asset('img/avatar.png')}}" style="width: auto; height: 30px;">
    </td>
    <td> {{ $remark->first_name }}</td>
    <td>
      <a class="btn btn-fill btn-block btn-sm btn-primary" href="{{ url('/employees/'.$remark->id.'/edit')}}">
      Edit
      </a>
    </td>

  </tr>
@empty
  <tr>
    <td class="text-center">
   <h3>NO REMARKS</h3>
    </td>
  </tr>
@endforelse
    <tr>
      <td colspan="3" class="text-center">
          <a href="{{url('/remarks')}}">
              See More <span class="badge">{{$remarks_total->count()}}</span>
          </a>
      </td>
    </tr>
  </tbody>
</table> 
  </div>

</div>


</div><!-- end col-md-8 -->

<!-- <div class="col-md-6">


<div class="panel panel-default">
  <div class="panel-heading">
       <div class="header">
          <h4 class="title">
          Upcoming Birthdays</h4>
          <p class="category">As of this month: {{ date('F, Y', strtotime( Carbon\Carbon::now())) }}</p>


      </div>
  </div>
  <div class="panel-body table-panel">
  <table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th></th>
      <th>ID</th>
      <th>Name</th>
      <th>Company</th>

    </tr>
  </thead>
  <tbody>
@foreach($birthdays as $birthday)
  <tr>
    <td>
      <img class="img-responsive" src="{{asset('img/avatar.png')}}" style="width: auto; height: 30px;">
    </td>
    <td> {{ $birthday->first_name }}</td>
    <td>{{ date('F d', strtotime($birthday->birthdate )) }}</td>
    <td>{{ $birthday->location }}</td>
 </tr>
@endforeach
  </tbody>
</table> 
  </div>

</div>


</div> -->

</div> <!-- end row -->
</div>



@endsection