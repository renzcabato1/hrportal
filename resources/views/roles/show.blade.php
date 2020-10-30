@extends('layouts.app')
 
@section('content')

  <div class="row" style="padding-top: 20px ! important;">
           
        

        <div class="panel panel-primary">
  <div class="panel-heading">
               <h3 class="panel-title">Show Role
                
               </h3>
    
  </div>
  <div class="panel-body">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $role->display_name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $role->description }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong>
                @if(!empty($rolePermissions))
					@foreach($rolePermissions as $v)
						<label class="label label-success">{{ $v->display_name }}</label>
					@endforeach
				@endif
            </div>
        </div>
	</div>


  </div>
</div>


</div>


@endsection