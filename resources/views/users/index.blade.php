@extends('layouts.app')
@section('content')


 <div class="row top-heading">
<div class="row">
<div class="col-sm-12">

<div class="panel panel-default">
  <div class="panel-heading">
      <div class="row">
          <div class="col-md-6">
                <div class="header">
                      <h4 class="title">
                      All Users</h4>
                      <p class="category">List of all Users</p>
                </div>
          </div>
          <div class="col-md-6">
          <h4 class="title pull-right">
            <a class="btn btn-fill btn-sm btn-danger" href="{{url('roles')}}">
            <i class="ion-unlocked"></i>  Manage Roles
              </a>
              </h4>
              
          </div>
      </div>


  </div>
 <div class="panel-body">

	<form method="GET" action="" class="custom_form"  enctype="multipart/form-data">
		<div class="form-group pull-right" style="width:50%">
			<div class="input-group">
			{!! Form::text('search', null,  ['class' => 'form-control','placeholder' => 'Input Here...']) !!}
			<span class="input-group-btn">
				<button class="btn btn-fill btn-submit" type="submit">Search</button>
			</span>
			</div>
		</div>
	</form>

 	<table class="dt-responsive table-striped  nowrap display table-responsive table-hover table-database table table-responsive" width="100%">
		<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Roles</th>
					<th>Action</th>
				</tr>
		</thead>
		<tfoot>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Roles</th>
					<th>Action</th>
				</tr>
		</tfoot>

		<tbody>
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>
					@if(!empty($user->roles))
						@foreach($user->roles as $v)
							<label class="label label-success">{{ $v->display_name }}</label>
						@endforeach
					@endif
				</td>
				<td>
					
					<a class="btn btn-fill btn-sm"  href="{{ route('users.edit',$user->id) }}">
					<i class="ion-wand"></i> Edit</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	
	</table>

	{!! $users->render() !!}

  </div><!-- end panel-body -->
</div><!-- end panel -->



</div><!-- end col-sm-12 -->



</div><!-- end row -->


 </div><!-- end top heading -->




@endsection
	