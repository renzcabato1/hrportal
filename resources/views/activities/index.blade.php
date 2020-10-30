@extends('layouts.app')
@section('content')
@inject('activity', 'App\Http\Controllers\ActivityController')
    <div class="top-heading"> 
        <div class="row">
            <div class="col-sm-12">


            <div class="panel panel-default">
  <div class="panel-heading">
      <div class="row">
          <div class="col-md-6">
                <div class="header">
                      <h4 class="title">
                      System Logs</h4>
                      <p class="category">List of all System Logs</p>
                </div>
          </div>
          <div class="col-md-6">
       
              
          </div>
      </div>


  </div>
 <div class="panel-body">

            
                <div class="row mb-3">
                <div class="col-sm-12">
                     {{ Form::open(array('url' => '/generateActivities', 'method' => 'get')) }}
                        <form>

                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                                        <label>Start Date</label>
                                        {!! Form::input('date','start_date', Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'max' => ''.date('Y-m-d', strtotime(Carbon\Carbon::now())).'' ]) !!}
                                         @if ($errors->has('start_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('start_date') }}</strong>
                                            </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                                        <label>End Date</label>
                                        {!! Form::input('date', 'end_date', Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'max' => ''.date('Y-m-d', strtotime(Carbon\Carbon::now())).'' ]) !!} 
                                        @if ($errors->has('end_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('end_date') }}</strong>
                                            </span>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit"  class="btn btn-secondary  btn-block">Generate</button>
                            </div>
                        </div>

                        
                        </form>
                    {!! Form::close() !!} 
                </div>             
             </div>

             <hr/>

 

 <table id="table-data" class="dt-responsive table-striped  nowrap display table-responsive table-hover table-database table table-responsive">
                    <thead>
                        <tr>
                            <th>
                                Event
                            </th>
                            <th>
                                User Name
                            </th>
                            <th>
                                Model
                            </th>
                            <th>
                                Module ID
                            </th>
                            <th>
                                IP Address
                            </th>
                            <th>
                                Log Date
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audits as $audit)
                        <tr>
                            <td>
                                 {{ $audit->event }}
                            </td>
                            <td>
                                {{ $activity->findUser($audit->user_id) }}
                            </td>
                            <td>
                                {{ $audit->auditable_type }}
                            </td>
                            <td>
                                <a href="{{ $audit->url }}">
                                    {{ $audit->auditable_id }}
                                </a>
                            </td>
                            <td>
                                {{ $audit->ip_address }}
                            </td>
                            <td>
                                {{ date('F d, Y  h:i:s A', strtotime($audit->created_at)) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="6">
                                NO RECORD FOUND
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>





  </div><!-- end panel-body -->
</div><!-- end panel -->


               


            </div><!-- end col-sm-12 -->
        </div><!-- end row -->



          <div class="row">
            <div class="col-sm-12">


            <div class="panel panel-default">
  <div class="panel-heading">
      <div class="row">
          <div class="col-md-6">
                <div class="header">
                      <h4 class="title">
                      System Administrators</h4>
                      <p class="category">List of all System Admin</p>
                </div>
          </div>
          <div class="col-md-6">
       
              
          </div>
      </div>


  </div>
 <div class="panel-body">

            
        
 <table class="dt-responsive table-striped  nowrap display table-responsive table-hover table-database table table-responsive">
                    <thead>
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Roles
                            </th>
                            <th>
                                IP Address
                            </th>
                            <th>
                               Last Login
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                 {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                            </td>
                            <td>
                                {{ $user->last_login_ip }}
                            </td>
                            <td>
                             {{ date('F d, Y  h:i:s A', strtotime($user->last_login_at)) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="6">
                                NO RECORD FOUND
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>





  </div><!-- end panel-body -->
</div><!-- end panel -->


               


            </div><!-- end col-sm-12 -->
        </div><!-- end row -->
    </div><!-- end top-heading -->
@endsection