@extends('layouts.app')
@section('content')

<div class="top-heading">
<div class="row">
	<div class="col-md-12">

		<div class="panel panel-default">
  <div class="panel-heading">
       <div class="header">
          <h4 class="title">
          Employee's Remarks</h4>
          <p class="category">As of this month: {{ date('F, Y', strtotime( Carbon\Carbon::now())) }}</p>


      </div>
  </div>
  <div class="panel-body table-panel">
  <table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th></th>
      <th>Name</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
@forelse($remarks as $remark)
  <tr>
    <td>
      <img class="img-responsive" src="{{asset('img/avatar.png')}}" style="width: auto; height: 30px;">
    </td>
    <td> {{ $remark->first_name }}</td>
    <td>
      <a class="btn btn-fill btn-block btn-sm btn-primary" href="{{ url('/employees/'.$remark->id.'/edit')}}">
      Edit
      </a>
    </td>

  </tr>
@empty
  <tr>
    <td class="text-center">
   <h3>NO REMARKS</h3>
    </td>
  </tr>
@endforelse
  </tbody>
</table> 
  </div>

</div>



	</div>
</div>
</div><!-- end top heading -->

@endsection