

<div class="panel panel-default">
  <div class="panel-heading">
       <div class="header">
          <h4 class="title">
          Fields Settings</h4>
          <p class="category">As of this month: {{ date('F, Y', strtotime( Carbon\Carbon::now())) }}</p>
      </div>
  </div>
  <div class="panel-body table-panel">
  <table class="table table-hover settings_table">

  <tbody>
      <tr class="{{ Request::path() == 'company' ? 'info' : '' }}">
          <td>
          <a href="{{url('/company')}}">
          Manage Companies<br/>
          </a>
          <small class="text-muted">{{$total_company->count()}} total entries</small>
          </td>

      </tr>

      <tr class="{{ Request::path() == 'department' ? 'info' : '' }}">
        <td>
        <a href="{{url('/department')}}">
        Manage Department<br/>
        </a>
        <small>{{$total_department->count()}} total entries</small>
        </td>
      </tr>


     <tr class="{{ Request::path() == 'location' ? 'info' : '' }}">
          <td>
          <a href="{{url('/location')}}">
          Manage Locations<br/>
          </a>
          <small>{{$total_location->count()}} total entries</small>
          </td>

      </tr>
  </tbody>
</table> 
  </div>

</div>




