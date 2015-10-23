@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">

	<!-- Button to Create new ticket -->
		<a href="../tickets/create"><button type="submit" class="btn btn-success"><i class="fa fa-lg fa-plus-circle"></i> New Ticket</button></a>
	<br>
	<br>

	<!-- Show errors or success of deleting -->
	<div class="panel-body">
        @if(Session::get('errors'))
          	<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>There were some errors:</h5>
            @foreach($errors->all('<li>:message</li>') as $message)
              {{$message}}
            @endforeach
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
	                <th>First Name</th>
	                <th>Room</th>
	                <th>Place</th>
	                <th>Check in</th>
	                <th>Check out</th>
	                <th>Type</th>
	                <th>Action</th>
	            </tr>
	        </thead>
	 
	        <tfoot>
	            <tr>
	                <th>First Name</th>
	                <th>Room</th>
	                <th>Place</th>
	                <th>Check in</th>
	                <th>Check out</th>
	                <th>Type</th>
	                <th>Action</th>
	            </tr>
	        </tfoot>
	 
	        <tbody>
	        	@foreach($tickets as $ticket)
	        	<tr>
	        		<!-- Ticket Info -->
	                <td>{{$ticket->user->first_name}}</td>
	                <td>{{$ticket->user->room_number}}</td>
	                <td>{{$ticket->place}}</td>
	                <td>{{$ticket->check_in}}</td>
	                <td>{{$ticket->check_out}}</td>

		     	  	<!-- Define the an array with the types of tickets -->
		     	  	{{--*/ $types = array('1' => 'Local', '2' => 'Foreign', '3' => 'Absence', '4' => 'Out of time') /*--}}

		     	  	<!-- set the ticket type according to the array-->
	                <td>{{$types[$ticket->type]}}</td>
	                <td>
	                	<div class="row">
	                		<div class="col-sm-6 pull-right text-center">
	                			<!-- Form that delete ticket-->
				                {{ Form::open(array('url' => 'tickets/' . $ticket->id)) }}

				                    {{ Form::hidden('_method', 'DELETE') }}
				                    {{ Form::button('<i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="left" title="Delete"></i>', array('type' => 'submit', 'class' => 'delete-btn')) }}
				                
				                {{ Form::close() }}
	                		</div>
	                		<div class="col-sm-6 text-center">
	                			<!-- Form that edit ticket-->
		             	   		<a  href="{{ URL::to('tickets/' . $ticket->id . '/edit') }}"> <i class="fa fa-pencil-square-o fa-lg" data-toggle="tooltip" data-placement="left" title="Edit"></i></a>
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
				<i class="fa fa-file"></i> Show tickets
	        </li>
	    </ol>
</div>
@stop
