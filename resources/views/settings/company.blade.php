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
        <li class="active"><a href="{{url('/company')}}">Companies</a></li>
        <li><a  href="{{url('/department')}}">Departments</a></li>
        <li><a href="{{url('/location')}}">Locations</a></li>
        <li><a href="{{url('/address')}}">Addresses</a></li>
        <li><a href="{{url('/head')}}">Head Positions</a></li>
        <li><a href="{{url('/level')}}">Levels</a></li>
        <li><a href="{{url('/marital_status')}}">Marital Statuses</a></li>
    </ul>
    </div>
</div>
<div id="my-tab-content" class="tab-content text-center">
    <div class="tab-pane active" id="home">

    <form method="POST" action="{{url('/company')}}" class="custom_form"  enctype="multipart/form-data">
    {{csrf_field()}}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <div class="input-group">
    {!! Form::text('name', null,  ['class' => 'form-control','placeholder' => 'Add Company']) !!}
    @if ($errors->has('name'))
    <span class="help-block">
    <strong>{{ $errors->first('name') }}</strong>
    </span>
    @endif   
    <span class="input-group-btn">
      <button class="btn btn-default btn-submit" type="submit">Add Company</button>
    </span>
</div>
</div>


</form>


<table class="table table-hover">
  <thead>
    <tr>

      <th>Company name</th>
      <th class="text-center" colspan="2">
     Action
      </th>
    </tr>
  </thead>
  <tbody>

@foreach($companies as $company)

      <tr>

     <td class="text-left" width="50%">
      {{$company->name}}
      </td>
     <td width="25%">
      <button class="btn btn-fill btn-block btn-sm" data-toggle="modal" data-target=".bs-delete{{$company->id}}-modal-lg"><i class="fa fa-trash"></i> Delete</button>
      </td>

      <td width="25%">
      <button class="btn  btn-fill btn-block btn-primary btn-sm" data-toggle="modal" data-target=".bs-edit{{$company->id}}-modal-lg"><i class="fa fa-pencil-square-o" ></i> Edit</button>
      </td>


    </tr>

@endforeach   
   
  </tbody>
</table> 

{!! $companies->render() !!}


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


@foreach($companies as $company)

<!-- modal edit form -->
<div class="modal fade bs-edit{{$company->id}}-modal-lg" tabindex="-1" style="margin-top: 100px;" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit company</h4>
        </div>
        <div class="modal-body">
                <div class="row">
          <div class="col-md-12">
                  <div class="panel-body"> 
                      
            {!! Form::model($company, ['method' => 'PATCH','enctype'=>'multipart/form-data', 'action' => ['SettingsController@updateCompany', $company->id], 'id' => 'frmEdit-' . $company->id, 'class' => 'form-horizontal bootstrap-modal-form']) !!} 
                        {{csrf_field()}}

          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

            <div class="col-md-12">
              {!! Form::text('name', null,  ['class' => 'form-control','placeholder' => 'Add Company']) !!}
                
            @if ($errors->has('name'))
            <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
            <br>
            <h6><strong>Divisions</strong></h6>
            <div class="table-responsive">
              <table class="table table-hover" id="tab_assign_head">
                  <thead>
                      <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            Name
                        </th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <td colspan="5">
                              <a data-id="{{$company->id}}" class=" add_division_head_row btn btn-sm  btn-fill  pull-left"><i class="ion-plus"></i> Add Row</a>
                              <a data-id="{{$company->id}}" class="delete_division_head_row pull-right btn btn-fill  btn-sm "><i class="ion-minus"></i> Delete Row</a>
                          </td>
                      </tr>
                  </tfoot>  
                  <tbody id="division-tbody{{$company->id}}">
                      @if(count($company->divisions) > 0) 
                        @foreach($company->divisions as $key => $division)
                          <tr id='division-headr{{$key}}' class="division-tr{{$division->id}}">
                            <td align="center" width="5%">
                                <input type="hidden" name="division[{{$key}}][id]" value="{{$division->id}}"> {{ Form::checkbox('division['.$key.'][delete]',null,null, array('id'=>'division-headr-check-'.$division->id,'id'=>$division->id,'class'=>'delete-division-checkbox')) }}
                                <span>Delete</span>
                            </td>
                            <td class="{{ $errors->has('name[]') ? ' has-error' : '' }}" width="20%">
                                {!! Form::text('division['.$key.'][name]', $division->name, ['class' => 'form-control']) !!}
                                @if ($errors->has('name'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('name[]') }}</strong>
                                  </span> 
                                @endif
                            </td>
                        </tr>
                        @endforeach
                      @else
                        <tr id='division-headr0'>
                            <td width="10%" align="center" >1</td>
                            <td width="20%">
                                {!! Form::text('division[0][name]', null, ['class' => 'form-control']) !!}
                            </td>
                        </tr>
                      @endif
                  </tbody>
                
              </table>
            </div>
            <br> 
              <input id="img_file" name="image_name" type="file" class="form-control" accept="image/png" onchange="document.getElementById('output{{$company->id}}').src = window.URL.createObjectURL(this.files[0])"> 
            <br> 
            <center>
          @if (file_exists( public_path() . '/id_image/company/' . $company->id . '.png'))
            <img src="{{url('/id_image/company/' . $company->id .'.png')}}" id="output{{$company->id}}"  style="width:50%;height:auto;border:1px dotted ;"/>
          @else
            <img src="{{url('/id_image/company/preview.png')}}" id="output{{$company->id}}" style="width:50%;height:auto;border:1px dotted ;"/>
          @endif
          </center>
        <br>
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
<div class="modal fade bs-delete{{$company->id}}-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="margin-top: 100px;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete a company</h4>
      </div>
      <div class="modal-body">
              <div class="row">
        <div class="col-md-12">
        <div class="panel-body text-center"> 
        <p>  
            Are you sure you want to delete a company ?
        </p>
        <em>
        <small>This will affect employees that selects under this name</small>
        </em>
                    
     <form method="POST" action="company/{{$company->id}}">
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

  <script>
    var fileToRead = document.getElementById("img_file");
      fileToRead.addEventListener("change", function(event) {
          var files = fileToRead.files;
      }, false);
  </script>
@endsection

@section('division_list')
<script>
   $(document).ready(function() {

      $('input[type=text]').keyup(function() {
          var v = $(this).val();
          var u = v.toUpperCase();
          if( v != u ) $(this).val( u );
      });

      $(".add_division_head_row").click(function() {
          var id = $(this).attr('data-id');
          var division_hdr = $('#division-tbody'+id+' tr').last().attr('id');
          var count_hdr = 0;
         
          if (division_hdr) {
            count_hdr = division_hdr.replace("division-headr", "");
            count_hdr++;
          }else{
            count_hdr = 0;
          }

          $('#division-tbody'+id).append(
              '<tr id="division-headr'+count_hdr+'"><td width="5%" align="center">'+ (count_hdr+1) +'</td><td width="20%"><input class="form-control" name="division['+count_hdr+'][name]" type="text"></td></tr>'
            );
          
          $('input[type=text]').keyup(function() {
              var v = $(this).val();
              var u = v.toUpperCase();
              if( v != u ) $(this).val( u );
          });
      });

      $(".delete_division_head_row").click(function() {
          var id = $(this).attr('data-id');
          var division_hdr = $('#division-tbody'+id+' tr').last().attr('id');
          division_hdr = division_hdr.replace("division-headr", "");
          if (division_hdr > 0) {
              $("#division-headr" + division_hdr).remove();
          }
      });

      $('.delete-division-checkbox').change(function() {
          var id = $(this).attr('id')
          if (this.checked) {
              $(".division-tr" + id).css("background-color", "#FF4D4D");
          } else {
              $(".division-tr" + id).css("background-color", "#FFFFFF");

          }
      });

    });
</script>
@endsection