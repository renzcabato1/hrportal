@extends('layouts.app')

@section('content')


<div class="top-heading"> 
<div class="row">
<div class="col-sm-12">

<div class="panel panel-default">
  <div class="panel-heading">
      <div class="row">
          <div class="col-md-6">
                <div class="header">
                      <h4 class="title">
                      Total Update for {{ date('M',strtotime(Carbon\Carbon::now())) }} - {{$total_update->count()}}</h4>
                      <p class="category">List of all Employees who updated their information</p>
                </div>
          </div>
          <div class="col-md-6">
          <h4 class="title pull-right">
            <a class="btn btn-fill btn-sm btn-primary" href="{{url('employees/create')}}">
            <i class="ion-person-add"></i>  Add Employee
              </a>
              </h4>
              
          </div>
      </div>


  </div>
 <div class="panel-body">



<table id="table-data" class="dt-responsive table-striped  nowrap display table-responsive table-hover table-database table table-responsive" width="100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Full Name</th>
                  <th>Position</th>
                  <th>Company</th>
                  <th>Department</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                 <th>#</th>
                  <th>Full Name</th>
                  <th>Position</th>
                  <th>Company</th>
                  <th>Department</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach($total_update as $employee)
              <tr>
              <td>{{$employee->employee_number}}</td>
              <td>{{$employee->full_name}}</td>
              <td>{{  str_limit($employee->position, 10)  }}</td>
              <td>{{$employee->company}}</td>
              <td>
             <!--  {{$employee->department}} -->
              @foreach($employee->departments as $department)
              {{$department->name}}
              @endforeach
              </td>
              <td>
                <a class="btn btn-fill btn-sm" href="{{url('employees/'.$employee->id.'/edit')}}">
                  <i class="ion-wand"></i>  Edit
                </a>

              </td>
          
              </tr>
              @endforeach
              </tbody>
              </table>



  </div><!-- end panel-body -->
</div><!-- end panel -->



</div><!-- end col-sm-12 -->



</div><!-- end row -->
</div><!-- end top-heading -->







@endsection