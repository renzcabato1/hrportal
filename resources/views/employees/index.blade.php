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
                      All Employees</h4>
                      <p class="category">List of all Employee</p>
                </div>
          </div>
          <div class="col-md-6">
          <h4 class="title pull-right">
            @if(!Auth::user()->hasRole('Administrator Printer'))
              <a class="btn btn-fill btn-sm btn-primary" href="{{url('employees/create')}}">
              <i class="ion-person-add"></i>  Add Employee
              </a>
            @endif
          </h4>
          </div>
      </div>


  </div>
 <div class="panel-body">
    <div class="form-group pull-right" style="width:100%">
      <form method="GET" action="" class="custom_form"  enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-3">
                {!! Form::text('search', null,  ['class' => 'form-control','placeholder' => 'Input Here...']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::select('company_list', $companies, null,  ['class' => 'form-control','style'=>'margin-top:0px;', 'placeholder' => '****Filter by Company']) !!} 
            </div>
            <div class="col-md-3">
                {!! Form::select('location_list', $locations, null,  ['class' => 'form-control','style'=>'margin-top:0px;', 'placeholder' => '****Filter by Location']) !!} 
            </div>
            <div class="col-md-2">
                <button class="btn btn-fill btn-sm btn-submit" style="width:100px;border-radius:4px" type="submit">Search</button>
            </div>
          </div>
      </form>
    </div>
      
    <table class="dt-responsive table-striped  nowrap display table-responsive table-hover table-database table table-responsive" width="100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Position</th>
            <th>Company</th>
            <th>Department</th>
            <th>Location</th>
            <th></th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Position</th>
            <th>Company</th>
            <th>Department</th>
            <th>Location</th>
            <th></th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
            @foreach($employees as $employee)
            <tr>
            <td>{{$employee->employee_number}}</td>
            <td>{{$employee->full_name}}</td>
            <td>{{  str_limit($employee->position, 10)  }}</td>
            <td>
                @foreach($employee->companies as $company)
                  {{$company->name}}
                @endforeach
            </td>
            <td>
              <!--  {{$employee->department}} -->
                @foreach($employee->departments as $department)
                {{$department->name}}
                @endforeach
            </td>
            <td>
              <!--  {{$employee->location}} -->
                @foreach($employee->locations as $location)
                {{$location->name}}
                @endforeach
            </td>

              <td>
                @if($employee->print_id_logs->count() > 0)
                  <i title="Already Printed" class="ion-card btn-id-remarks" data-id="{{$employee->id}}" style="color:green;font-size:18px;cursor:pointer;"></i>
                @else
                  <i title="Not Printed" class="ion-card" style="color:red;font-size:18px"></i>
                @endif
              </td>
              <td>

                @if(Entrust::hasRole('Administrator Printer'))

                  <button class="btn btn-fill btn-sm" onclick="setURL('employees/new_print_id/{!!$employee->id!!}')" data-toggle="modal" data-target="#previewID" style="margin-bottom:5px;" >
  
                    <i class="ion-eye"></i> Preview
                  </button>

                  <a class="btn btn-fill btn-sm btn-print" data-id="{{$employee->id}}" data-count="{{ $employee->print_id_logs->count() }}" data-href="{{url('employees/'.$employee->id.'/print_id')}}" >
                    <i class="ion-printer"></i> Print ID
                  </a>
                  
                @else
                  <a class="btn btn-fill btn-sm" href="{{url('employees/'.$employee->id.'/edit')}}" style="margin-bottom:5px;" >
                    <i class="ion-wand"></i>  Edit    
                  </a>

                  <a class="btn btn-fill btn-sm" href="{{url('organizational_chart/'.$employee->id)}}" style="margin-bottom:5px;">
                    <i class="pe-7s-share"></i>  Organizational Chart    
                  </a>
                  
                  {{-- Mam Donna ID --}}
                  @if(Auth::user()->id == '1324') 
                    @if($employee->tag)
                        @if($employee->tag->tag_status == 1)
                          <a class="btn btn-fill btn-sm"  href="{{url('employees/'.$employee->tag->id.'/untag')}}">
                            <i class="ion-pricetags"></i>  Tagged
                          </a>
                        @else
                          <a class="btn btn-outline btn-sm" href="{{url('employees/'.$employee->id.'/tag')}}">
                            <i class="ion-pricetags"></i>  Tag
                          </a>
                        @endif
                    @else
                        <a class="btn btn-outline btn-sm" href="{{url('employees/'.$employee->id.'/tag')}}">
                          <i class="ion-pricetags"></i>  Tag
                        </a>
                    @endif
                  @endif

                @endif

              </td>
          
              </tr>
            @endforeach
          </tbody>
      </table>  
      {{ $employees->appends(['search' => app('request')->input('search'), "company_list"=>app('request')->input('company_list'), "location_list"=>app('request')->input('location_list')])->links() }}
  </div><!-- end panel-body -->
</div><!-- end panel -->



</div><!-- end col-sm-12 -->



</div><!-- end row -->
</div><!-- end top-heading -->

<div id="id-remarks-modal" class="modal fade bs-add-modal-lg" tabindex="-1" style="margin-top: 100px;" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">ID Remarks / Logs</h5>
        <table class="dt-responsive table-striped  nowrap display table-responsive table-hover table-database table table-responsive" width="100%">
            <thead>
              <tr>
                <th>Remarks</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody id="id-remarks">
              <tr>
                <td></td>
                <td></td>
              </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<div id="bs-modal" class="modal fade" tabindex="-1" style="margin-top: 100px;" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Remarks</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div id="viewport" role="main"></div>
          </div>
          <div class="col-md-12">
              <div class="panel-body"> 
                {!! Form::open(['url' => '/employees/add_print_log', 'method' => 'POST']) !!}                  
                {{csrf_field()}}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <div class="col-md-12">
                    <input id="employee_id" name="employee_id" type="hidden">
                    {!! Form::textarea('remarks', null,  ['id'=>'remarks','class' => 'form-control required','placeholder' => 'Add Remarks']) !!}  
                    @if ($errors->has('remarks'))
                    <span class="help-block">
                    <strong>{{ $errors->first('remarks') }}</strong>
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
</div>  


<div class="modal fade" id="previewID" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="width:80%!important;">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="col-12 modal-title text-center">ID Preview</h6>
              <br>
              <div class="col-md-12 text-center">
                  <iframe id="previewFrame" src="" frameborder="0" height="680px" width="100%"></iframe>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger btn-outline" data-dismiss="modal" aria-label="Close">
                  Close
              </button>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

<script>
  function setURL(url) {
      document.getElementById("previewFrame").src = url +'#toolbar=0&navpanes=0&scrollbar=0';
  }
  
  $(".btn-print").click(function(e) {
      e.preventDefault();
      data_id = $(this).attr('data-id');
      data_count = $(this).attr('data-count');
      data_href = $(this).attr('data-href');
      if(data_count < 1){
        window.location.replace(data_href);
      }else{
        $('#bs-modal').modal({
          show: 'true'
        }); 
        $('#remarks').val("");
        $('#employee_id').val(data_id);
      }
  });

  $(".btn-id-remarks").click(function(e) {
    e.preventDefault();
    data_id = $(this).attr('data-id');
    $.getJSON( "/get_id_remarks/"+data_id, function( data ) {
      var html = '',
      el = document.getElementById("id-remarks");
      $.each(data, function (key, val) {
          html += '<tr><td align="left">'+val.remarks+'</td><td align="left">'+val.created_at+'</td></tr>';
      });
      el.innerHTML = html;
    });
    $('#id-remarks-modal').modal({
      show: 'true'
    }); 
  });

</script>

@endsection