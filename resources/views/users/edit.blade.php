@extends('layouts.app')
 
@section('content')


     <div class="top-heading">
      
        <div class="panel">
  <div class="panel-heading">

                <div class="header">
                      <h4 class="title">
                      Edit User</h4>
                      <p class="category">Edit </p>
                </div>




    
  </div>
  <div class="panel-body">


 @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}


    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Password:</strong>
                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
            </div>
        </div>

        
        @role('Administrator')
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control', 'multiple')) !!}
            </div>
        </div>
        @endrole
       




    </div>


      <div class="row">
                    <div class="col-md-6">
              <a href="{{ route('users.index') }}" class="btn btn-fill btn-default btn-sm"> Cancel</a>                    
                  </div>

                    <div class="col-md-6">
                   {!! Form::submit('Submit', ['class' => 'btn btn-fill btn-submit-user btn-success pull-right btn-sm'])  !!}
                    </div>
                   </div> 
    {!! Form::close() !!}


  </div>
</div>


</div>

	
@endsection