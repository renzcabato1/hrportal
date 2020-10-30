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
                      All Roles</h4>
                      <p class="category">List of all Roles</p>
                </div>
          </div>
          <div class="col-md-6">
          <h4 class="title pull-right">
            <a class="btn btn-fill btn-sm btn-danger" href="{{url('roles/create')}}">
            <i class="ion-person"></i> Create Role
              </a>
              </h4>
              
          </div>
      </div>


  </div>
 <div class="panel-body">


  	<table class="dt-responsive table-striped  nowrap display table-responsive table-hover table-database table table-responsive">
  	<thead>
  		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Description</th>
		</tr>
  	</thead>
		
	@foreach ($roles as $key => $role)
	<tr>
		<td>{{ $role->id }}</td>
		<td>{{ $role->display_name }}</td>
		<td>{{ $role->description }}</td>

	</tr>
	@endforeach
	</table>
	{!! $roles->render() !!}


  </div><!-- end panel-body -->
</div><!-- end panel -->



</div><!-- end col-sm-12 -->



</div><!-- end row -->



</div><!-- end top-heading -->

@endsection