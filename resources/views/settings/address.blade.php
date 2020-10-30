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
        <li class="active"><a href="{{url('/address')}}">Addresses</a></li>
        <li><a href="{{url('/head')}}">Head Positions</a></li>
        <li><a href="{{url('/level')}}">Levels</a></li>
        <li><a href="{{url('/marital_status')}}">Marital Statuses</a></li>
    </ul>
    </div>
</div>
<div id="my-tab-content" class="tab-content text-center">
    <div class="tab-pane active" id="home">

<form method="POST" action="{{url('/address')}}" class="custom_form"  enctype="multipart/form-data">
{{csrf_field()}}

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
<div class="input-group">
{!! Form::text('name', null,  ['class' => 'form-control','placeholder' => 'Add Address']) !!}
@if ($errors->has('name'))
<span class="help-block">
<strong>{{ $errors->first('name') }}</strong>
</span>
@endif   
<span class="input-group-btn">
  <button class="btn btn-default btn-submit" type="submit">Add Address</button>
</span>
</div>
</div>


</form>


<table class="table table-hover">
  <thead>
    <tr>

      <th>Address</th>
      <th class="text-center" colspan="2">
     Action
      </th>
    </tr>
  </thead>
  <tbody>

@foreach($addresses as $address)

      <tr>

     <td class="text-left" width="50%">
      {{$address->name}}
      </td>
     <td width="25%">
      <button class="btn btn-fill btn-block btn-sm" data-toggle="modal" data-target=".bs-delete{{$address->id}}-modal-lg"><i class="fa fa-trash"></i> Delete</button>
      </td>

      <td width="25%">
      <button class="btn  btn-fill btn-block btn-primary btn-sm" data-toggle="modal" data-target=".bs-edit{{$address->id}}-modal-lg"><i class="fa fa-pencil-square-o" ></i> Edit</button>
      </td>


    </tr>

@endforeach   
   
  </tbody>
</table> 

{!! $addresses->render() !!}


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


@foreach($addresses as $address)

<!-- modal edit form -->
<div class="modal fade bs-edit{{$address->id}}-modal-lg" tabindex="-1" style="margin-top: 100px;" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Address</h4>
      </div>
      <div class="modal-body">
              <div class="row">
        <div class="col-md-12">
                <div class="panel-body"> 
                    
          {!! Form::model($address, ['method' => 'PATCH','enctype'=>'multipart/form-data', 'action' => ['SettingsController@updateAddress', $address->id], 'id' => 'frmEdit-' . $address->id, 'class' => 'form-horizontal bootstrap-modal-form']) !!} 
                      {{csrf_field()}}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

        <div class="col-md-12">
        {!! Form::text('name', null,  ['class' => 'form-control','placeholder' => 'Add Address']) !!}  
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



<!-- Delete a company modal -->
<div class="modal fade bs-delete{{$address->id}}-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top: 100px;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete a address</h4>
      </div>
      <div class="modal-body">
              <div class="row">
        <div class="col-md-12">
        <div class="panel-body text-center"> 
        <p>  
            Are you sure you want to delete a address ?
        </p>
        <em>
        <small>This will affect locations that selects under this address.</small>
        </em>
                    
     <form method="POST" action="address/{{$address->id}}">
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