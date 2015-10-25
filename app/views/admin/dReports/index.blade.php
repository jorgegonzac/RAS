@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">

	<!-- Button to Create new ticket -->
		<a href="../dReports/create"><button type="submit" class="btn btn-success"><i class="fa fa-lg fa-plus-circle"></i> New Disciplinary Report</button></a>
	<br>
	<br>

	<!-- Show errors or success of deleting -->
	<div class="panel-body">
        @if($errors = Session::get('errors'))
          	<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>There were some errors:</h5>
              {{$errors}}
          </div>
        @elseif($success = Session::get('success'))        	
	        <div class="alert alert-success alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h5>Success:</h5>
	          	{{$success}}
    	    </div>	
        @endif
    </div>

	<!-- This table was created with the datatable api -->
	<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	                <th>Name</th>
	                <th>Room</th>
	                <th>Description</th>
	                <th>Date</th>
	                <th>Action</th>
	            </tr>
	        </thead>
	 
	        <tfoot>
	            <tr>
	                <th>Name</th>
	                <th>Room</th>
	                <th>Description</th>
	                <th>Date</th>
	                <th>Action</th>
	            </tr>
	        </tfoot>
	 
	        <tbody>
	        	@foreach($dReports as $report)
	        	<tr>
	        		<!-- Ticket Info -->
	                <td>{{$report->user->first_name}} {{$report->user->last_name}}</td>
	                <td>{{$report->user->room_number}}</td>
	                <td>
		                <textarea class="textarea" rows="4" disabled> {{$report->description}} </textarea>
	                </td>
	                <td>{{$report->date}}</td>
	                <td>
	                	<div class="row">
	                		<div class="col-sm-6 pull-right text-center">
	                			<!-- Form that delete ticket-->
				                {{ Form::open(array('url' => 'dReports/' . $report->id)) }}

				                    {{ Form::hidden('_method', 'DELETE') }}
				                    {{ Form::button('<i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="left" title="Delete"></i>', array('type' => 'submit', 'class' => 'delete-btn')) }}
				                
				                {{ Form::close() }}
	                		</div>
	                		<div class="col-sm-6 text-center">
	                			<!-- Form that edit ticket-->
		             	   		<a  href="{{ URL::to('dReports/' . $report->id . '/edit') }}"> <i class="fa fa-pencil-square-o fa-lg" data-toggle="tooltip" data-placement="left" title="Edit"></i></a>
	                		</div>
	                	</div>	                		                
	            	</td>
	            </tr>
	            @endforeach
	        </tbody>
	    </table>
	    <ol class="breadcrumb">
	    	<li>
	                <i class="fa fa-dashboard"></i>  <a href="../admin">Dashboard</a>
	        </li>
			<li class="active">
				<i class="fa fa-file"></i> Show disciplinary reports
	        </li>
	    </ol>
</div>
@stop
