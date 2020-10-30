@extends('layouts.app')
@section('content')
 
<div class="top-heading"> 
 @if (count($errors) > 0)

    <div class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Oh snap!</strong> There were some problems with your input. and try submitting again.
</div>
    @endif

       {!! Form::model($employee = new \App\Employee,  ['class' => 'form-horizontal',  'url' => 'employees',  'files' => 'true', 'enctype'=>'multipart/form-data', 'novalidate' => 'novalidate', 'id' => 'employeesForm'])!!}
        {!! csrf_field() !!}

        @include('employees.form', ['submitButtonText' => 'Confirm'])

    
		{!! Form::close() !!}


</div>



@endsection


