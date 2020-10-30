@extends('layouts.app')
@section('content')


<div class="top-heading">
<div class="row">
<div class="col-md-12">

<div class="panel panel-default">
<div class="panel-body">
<div class="nav-tabs-navigation">
    <div class="nav-tabs-wrapper">
    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li><a href="{{url('/company')}}">Companies</a></li>
        <li><a  href="{{url('/department')}}">Departments</a></li>
        <li><a href="{{url('/location')}}">Locations</a></li>
        <li><a href="{{url('/address')}}">Addresses</a></li>
        <li class="active"><a href="{{url('/head')}}">Head Positions</a></li>
        <li><a href="{{url('/level')}}">Levels</a></li>
        <li><a href="{{url('/marital_status')}}">Marital Statuses</a></li>
    </ul>
    </div>
</div>
<div id="my-tab-content" class="tab-content text-center">
    <div class="tab-pane active" id="home">

  <form method="POST" action="{{url('/head')}}" class="custom_form"  enctype="multipart/form-data">
{{csrf_field()}}

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
<div class="input-group">
{!! Form::text('name', null,  ['class' => 'form-control','placeholder' => 'Add Head']) !!}
@if ($errors->has('name'))
<span class="help-block">
<strong>{{ $errors->first('name') }}</strong>
</span>
@endif   
<span class="input-group-btn">
  <button class="btn btn-default btn-submit" type="submit">Add Head</button>
</span>
</div>
</div>


</form>


<table class="table table-hover">
  <thead>
    <tr>

      <th>Head Position Name</th>
      <th class="text-center" colspan="2">
     Action
      </th>
    </tr>
  </thead>
  <tbody>

@foreach($heads as $head)

      <tr>

      <td class="text-left" width="50%">
      {{$head->name}}
      </td>
        <td width="25%">
       <button class="btn btn-fill btn-block btn-sm"  data-toggle="modal" data-target=".bs-delete{{$head->id}}-modal-lg"><i class="fa fa-trash"></i> Delete</button>
      </td>

      <td width="25%">
      <button class="btn  btn-fill btn-block btn-primary btn-sm" data-toggle="modal" data-target=".bs-edit{{$head->id}}-modal-lg"><i class="fa fa-pencil-square-o" ></i> Edit</button>
      </td>
    </tr>

@endforeach   
   
  </tbody>
</table> 

{!! $heads->render() !!}


    </div>
    <div class="tab-pane" id="profile">
        <p>Here is your profile.</p>
    </div>
    <div class="tab-pane" id="messages">
        <p>Here are your messages.</p>
    </div>
</div>

</div>
</div>
</div>
</div>  <!-- end row -->









</div><!-- end top header -->


  @foreach($heads as $head)

<!-- modal edit form -->
<div class="modal fade bs-edit{{$head->id}}-modal-lg" style="margin-top: 100px;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit head</h4>
      </div>
      <div class="modal-body">
              <div class="row">
        <div class="col-md-12">
          <div class="panel-body"> 
              
          {!! Form::model($head, ['method' => 'PATCH', 'action' => ['SettingsController@updateHead', $head->id], 'id' => 'frmEdit-' . $head->id, 'class' => 'form-horizontal bootstrap-modal-form']) !!} 
          {{csrf_field()}}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="col-md-12">
              {!! Form::text('name', null,  ['class' => 'form-control','placeholder' => 'Add head']) !!}   
              @if ($errors->has('name'))
                <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>
                                             
    </div>
        </div>
    </div>
      </div>
      <div class="modal-footer">
        <div class="left-side">
            <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Cancel</button>
        </div>
          <div class="divider"></div>
            <div class="right-side">
            <button type="submit" class="btn btn-danger btn-simple">Submit</button>
        </div>  
          
           
      </div>
    {!! Form::close() !!}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->      



<!-- Delete a head modal -->
<div class="modal fade bs-delete{{$head->id}}-modal-lg" style="margin-top: 100px;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete a head</h4>
      </div>
      <div class="modal-body">
              <div class="row">
        <div class="col-md-12">
        <div class="panel-body text-center"> 
    
        <p>  
            Are you sure you want to delete a head ?
        </p>
        <em>
        <small>This will affect employees that selects under this name</small>
        </em>
                    
     <form method="POST" action="head/{{$head->id}}">
      {!! csrf_field() !!}
      <input type="hidden" name="_method" value="DELETE">   
                                        
    </div>
        </div>
    </div>
      </div>
      <div class="modal-footer">
        <div class="left-side">
            <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Cancel</button>
        </div>
          <div class="divider"></div>
            <div class="right-side">
            <button type="submit" class="btn btn-danger btn-simple">Confirm</button>
        </div>  
          
           
      </div>
      </form> 
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->      

@endforeach


@endsection