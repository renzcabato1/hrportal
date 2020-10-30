@extends('layouts.app')
@section('content')


<div class="top-heading">
<div class="row">
<div class="col-md-12">

<div class="panel panel-default">
    <div class="panel-heading">
    <div class="row">
        <div class="col-md-6">
              <div class="header">
                    <h4 class="title">
                    Employee Approval</h4>
                    <p class="category">List of all Employee Requests</p>
              </div>
        </div>
    </div>
</div>

<div class="panel-body">

<div id="my-tab-content" class="tab-content text-center">
<div class="tab-pane active" id="home">

<div class="form-group pull-right" style="width:100%">
    <form method="GET" action="" class="custom_form"  enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-5">
              {!! Form::text('search', null,  ['class' => 'form-control','placeholder' => 'Input Here...']) !!}
          </div>
          <div class="col-md-5">
              {!! Form::select('status', array('Pending'=>'Pending','Approved'=>'Approved','Disapproved'=>'Disapproved'), null,  ['class' => 'form-control','style'=>'margin-top:0px;', 'placeholder' => '****Filter by Status']) !!} 
          </div>
          <div class="col-md-2">
              <button class="btn btn-fill btn-sm btn-submit" style="width:100px;border-radius:4px" type="submit">Search</button>
          </div>
        </div>
    </form>
  </div>

<table class="table table-hover">
  <thead>
    <tr>

      <th>#</th>
      <th>Name</th>
      <th>Date Created</th>
      <th>Status</th>
      <th class="text-center" colspan="2">Action</th>
    </tr>
  </thead>
  <tbody>

      @foreach($employee_approval_requests as $key => $employee_approval_request)

            <tr>
            <td class="text-left">
              {{$key+1}}
            </td>
            <td class="text-left">
              {{$employee_approval_request->employee->full_name}}
            </td>
            <td class="text-left">
              {{$employee_approval_request->created_at}}
            </td>
            <td class="text-left">
              @if($employee_approval_request->status == "Pending")
                <span class="label label-warning">Pending</span>
              @endif
              @if($employee_approval_request->status == "Approved")
                <span class="label label-success">Approved</span>
              @endif
              @if($employee_approval_request->status == "Disapproved")
                <span class="label label-danger">Disapproved</span>
              @endif
            </td>
              <td width="5%">
            <button class="btn btn-fill btn-block btn-sm"  data-toggle="modal" data-target=".bs-show{{$employee_approval_request->id}}-modal-lg"><i class="fa fa-eye"></i> Show</button>
              </td>
          </tr>

      @endforeach   
        
  </tbody>
</table> 

{!! $employee_approval_requests->render() !!}


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

@foreach($employee_approval_requests as $key => $employee_approval_request)
  <!-- Delete a level modal -->
  <div class="modal fade bs-show{{$employee_approval_request->id}}-modal-lg" style="margin-top: 100px;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog" style="width:1140px;margin:30px auto;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{$employee_approval_request->employee->full_name}}</h4>
        </div>
        <div class="modal-body" style="max-width:4140px;">
                <div class="row">
          <div class="col-md-12">
          <div class="panel-body text-center"> 
        <table class="table table-hover table-bordered">
            <thead>
              <tr>
          
                <th width="20%;">*Field</th>
                <th><span class="label label-warning">Old</span></th>
                <th><span class="label label-success">New</span></th>
              </tr>
            </thead>
            <tbody> 
              <tr>
                <td align="left"> First Name</td><td align="left">{{ json_decode($employee_approval_request->original_employee_data)->first_name}}</td>
                <td align="left"> @if(json_decode($employee_approval_request->employee_data)->first_name != json_decode($employee_approval_request->original_employee_data)->first_name && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->first_name }}</td>
              </tr>
              <tr>
                <td align="left"> Middle Name</td><td align="left">{{json_decode($employee_approval_request->original_employee_data)->middle_name}}</td>
                <td align="left"> @if(json_decode($employee_approval_request->employee_data)->middle_name != json_decode($employee_approval_request->original_employee_data)->middle_name && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->middle_name }}</td>
              </tr>
              <tr>
                <td align="left"> Last Name</td><td align="left">{{json_decode($employee_approval_request->original_employee_data)->last_name}}</td>
                <td align="left"> @if(json_decode($employee_approval_request->employee_data)->last_name != json_decode($employee_approval_request->original_employee_data)->last_name && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->last_name }}</td>
              </tr>
              <tr>
                <td align="left"> Marital Status</td>
                <td align="left">{{json_decode($employee_approval_request->original_employee_data)->marital_status}}
                
                    @if(isset(json_decode($employee_approval_request->original_employee_data)->marital_status_attachment))
                      @if(json_decode($employee_approval_request->original_employee_data)->marital_status == "Married" || json_decode($employee_approval_request->original_employee_data)->marital_status == "Divorced")
                        <br>
                        <label>Attachment <a href="/files/marital_status_attachments/{{ json_decode($employee_approval_request->original_employee_data)->marital_status_attachment }}" target="_blank" > - View File</a></label>
                      @endif
                    @endif
                </td>
                <td align="left"> 
                  @if(json_decode($employee_approval_request->employee_data)->marital_status != json_decode($employee_approval_request->original_employee_data)->marital_status && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->marital_status }}
                  
                  @if(isset(json_decode($employee_approval_request->employee_data)->marital_status_attachment))
                    @if(json_decode($employee_approval_request->employee_data)->marital_status == "Married" || json_decode($employee_approval_request->employee_data)->marital_status == "Divorced")
                      <br>
                      <label>Attachment <a href="/files/marital_status_attachments/temps/{{ json_decode($employee_approval_request->employee_data)->marital_status_attachment }}" target="_blank" > - View File</a>
                      </label>
                    @endif
                  @endif
                </td>
              </tr>
              <tr>
              <td align="left">Current Address</td><td align="left">{{ json_decode($employee_approval_request->original_employee_data)->current_address}}</td>
              <td align="left"> @if(json_decode($employee_approval_request->employee_data)->current_address != json_decode($employee_approval_request->original_employee_data)->current_address && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->current_address }}</td>
              </tr>
              <tr>
                <td align="left">Permanent Address</td><td align="left">{{ json_decode($employee_approval_request->original_employee_data)->permanent_address}}</td>
                <td align="left"> @if(json_decode($employee_approval_request->employee_data)->permanent_address != json_decode($employee_approval_request->original_employee_data)->permanent_address && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->permanent_address }}</td>
              </tr>
              <tr>
                <td align="left">Phone Number</td><td align="left">{{ json_decode($employee_approval_request->original_employee_data)->phone_number}}</td>
                <td align="left"> @if(json_decode($employee_approval_request->employee_data)->phone_number != json_decode($employee_approval_request->original_employee_data)->phone_number && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->phone_number }}</td>
              </tr>
              <tr>
                <td align="left">Mobile Number</td><td align="left">{{ json_decode($employee_approval_request->original_employee_data)->mobile_number}}</td>
                <td align="left"> @if(json_decode($employee_approval_request->employee_data)->mobile_number != json_decode($employee_approval_request->original_employee_data)->mobile_number && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->mobile_number }}</td>
              </tr>
              <tr>
                <td align="left">Contact Person</td><td align="left">{{ json_decode($employee_approval_request->original_employee_data)->contact_person}}</td>
                <td align="left"> @if(json_decode($employee_approval_request->employee_data)->contact_person != json_decode($employee_approval_request->original_employee_data)->contact_person && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->contact_person }}</td>
              </tr>
              <tr>
                <td align="left">Contact Relation</td><td align="left">{{ json_decode($employee_approval_request->original_employee_data)->contact_relation}}</td>
                <td align="left"> @if(json_decode($employee_approval_request->employee_data)->contact_relation != json_decode($employee_approval_request->original_employee_data)->contact_relation && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->contact_relation }}</td>
                
              </tr>
              <tr>
                <td align="left">Contact Number</td><td align="left">{{ json_decode($employee_approval_request->original_employee_data)->contact_number}}</td>
                <td align="left"> @if(json_decode($employee_approval_request->employee_data)->contact_number != json_decode($employee_approval_request->original_employee_data)->contact_number && $employee_approval_request->status != "Approved") <i class="fa fa-exclamation-circle" style="color:#F3BB45"></i> @endif {{ json_decode($employee_approval_request->employee_data)->contact_number }}</td>
              </tr>
              
              @if(isset($employee_approval_request->employee_data_request()->dependent))
              <tr>
                <td colspan="3"><strong>HMO Dependents</strong></td>
              </tr>
                @foreach ($employee_approval_request->employee_data_request()->dependent as $key => $dependent)
                  <tr>
                    <td colspan="3" align="left">
                      @if(isset($dependent->id))
                        @if(isset($dependent->delete))
                          @if($dependent->delete == 'on')
                            <span class="label label-danger pull-right"> Delete </span> &nbsp;
                          @endif
                        @endif
                      @else 
                        <span class="label label-success pull-right"> New </span> &nbsp;
                      @endif
                      <strong> Name:</strong> {{ $dependent->dependent_name }} || 
                      <strong>Gender:</strong> {{ isset($dependent->dependent_gender) ? $dependent->dependent_gender : '' }} || 
                      <strong>Birthdate:</strong> {{ $dependent->bdate }} || 
                      <strong>Relation:</strong> {{ $dependent->relation }}   

                    </td>
                  </tr>
                @endforeach
              @endif
              
            </tbody> 
            <span class="pull-right"><i>Date Modified: {{ $employee_approval_request->created_at }}</i><span>       
          </table> 
             
            {!! Form::model($employee_approval_request, ['method' => 'PATCH', 'action' => ['SettingsController@updateEmployeeApprovalRequest', $employee_approval_request->id], 'id' => 'frmEdit-' . $employee_approval_request->id, 'class' => 'form-horizontal bootstrap-modal-form']) !!} 

              {!! csrf_field() !!}
              
              <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                <div class="col-md-12">
                  @if(Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff'))
                      @if($employee_approval_request->status == "Approved")
                        {!! Form::select('status', array(''=>'Select Approval Status','Approved'=>'Approved','Disapproved'=>'Disapproved') , null,['class' => 'dropdown-primary form-control','required','disabled']) !!}
                      @else 
                        {!! Form::select('status', array(''=>'Select Approval Status','Approved'=>'Approved','Disapproved'=>'Disapproved') , null,['class' => 'dropdown-primary form-control','required']) !!}
                      @endif
                      @if ($errors->has('status'))
                      <span class="help-block">
                      <strong>{{ $errors->first('status') }}</strong>
                      </span>
                      @endif
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
                @if(Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff'))
                  @if($employee_approval_request->status == "Approved")
                    <button type="submit" class="btn btn-danger btn-simple" disabled>Save</button>
                  @else 
                    <button type="submit" class="btn btn-danger btn-simple">Save</button>
                  @endif
                @endif
              
          </div>  
            
            
        </div>
        </form> 
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->      
@endforeach




<script>
  var $select2 = $('.select2').select2({
    containerCssClass: "wrap"
  })
</script>

@endsection