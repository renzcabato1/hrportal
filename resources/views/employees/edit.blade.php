   @extends('layouts.app')
@section('content')


<div class="top-heading"> 
   {!! Form::model($employee, ['method' => 'PATCH', 'action' => ['EmployeesController@update', $employee->id], 'class' => 'form-horizontal',  'files' => true, 'name' => 'autoSumForm' ]) !!} 
    {!! csrf_field() !!}
                    
 
                    
    @include('employees.form', ['submitButtonText' => 'Update'])



{!! Form::close() !!}

</div>

@endsection