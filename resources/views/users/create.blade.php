@extends('layouts.app')
 
@section('content')

     <div class="row">
           
        

        <div class="panel panel-primary">
  <div class="panel-heading">
               <h3 class="panel-title">Add new user
                 <a href="{{ url('users') }}" class="btn btn-info"><i class="fa fa-users"></i> All User</a>
               </h3>
    
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
    {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
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
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control')) !!}
            </div>
        </div>
       
    </div>

            <hr/>

          <div class="row">
                    <div class="col-md-6">
<a href="{{ route('users.index') }}" class="btn btn-default btn-sm"> Cancel</a>                    </div>

                    <div class="col-md-6">
                   {!! Form::submit('Submit', ['class' => 'btn btn-primary pull-right'])  !!}
                    </div>
                   </div> 
    {!! Form::close() !!}


  </div>
</div>


</div>

@endsection