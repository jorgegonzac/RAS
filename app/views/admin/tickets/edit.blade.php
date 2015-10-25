@extends('../../layouts/adminLayout')
@section('content')

<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      	<div class="panel-heading" align="center">
        	<h3>Edit Ticket</h3>
      	</div>
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

		{{ Form::model($ticket, array('method' => 'PATCH', 'route' => array('tickets.update', $ticket->id))) }}
				<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="username"> <h5>Username</h5></label>
		            	{{ Form::text('username', $ticket->user->username, array('class'=>'form-control input-sm', 'placeholder' => 'username', 'maxlength' => 9, 'required' => 'required', 'readonly' => 'readonly')) }}
		          	</div>
	        		<div class="col-sm-6 form-group">
						<label for="place"> <h5>Place</h5></label>
		            	{{ Form::text('place', $ticket->place, array('class'=>'form-control input-sm', 'placeholder' => 'place', 'maxlength' => 50, 'required' => 'required')) }}
		          	</div>
	        	</div>

	        	<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="phone"> <h5>Phone</h5></label>
		            	{{ Form::text('phone', $ticket->phone, array('class'=>'form-control input-sm', 'placeholder' => 'phone', 'maxlength' => 10, 'required' => 'required')) }}
		          	</div>

	        		<div class="col-sm-6 form-group">			          	
						<label for="type"> <h5>Type</h5></label>
			          	<!-- Select type-->
			          	<select class="form-control input-sm" name="type">	         

				     	  	<!-- Define the an array with the types of tickets -->
				     	  	{{--*/ $types = array('1' => 'Local', '2' => 'Foreign', '3' => 'Absence', '4' => 'Out of time') /*--}}

				     	  	<!-- Generate the select input using the array previously defined -->
				     	  	@foreach($types as $i => $type)
				     	  		<!-- Check if this option is the same as the ticket type-->
				     	  		@if($i == $ticket->type)
				     	  			<!-- Set the option as selected -->
						  	  		<option value="{{$i}}" selected>{{$types[$i]}}</option>
				     	  		@else
						  	  		<option value="{{$i}}">{{$types[$i]}}</option>
						  	  	@endif
				     	  	@endforeach

			     	  	</select>		
		          	</div>
	        	</div>

	        	<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="check-in"> <h5>Check-in</h5></label>
				     	<input name="check-in" id="check-in" class="check-in form-control input-sm" value="{{$ticket->check_in}}"> </input>
		          	</div>
	        		<div class="col-sm-6 form-group">
						<label for="check-out"> <h5>Check-out</h5></label>
				     	<input name="check-out" id="check-out" class="check-out form-control  input-sm" value="{{$ticket->check_out}}"> </input>
		          	</div>
	        	</div>

		          {{ Form::submit('Save', array('class'=>'btn btn-info btn-block')) }}
	        {{ Form::close() }}
	      </div>
	    </div>
	  </div>
	</div>
	<ol class="breadcrumb">
	    	<li>
	                <i class="fa fa-edit"></i>  <a href="../../tickets">Tickets</a>
	        </li>
			<li class="active">
				<i class="fa fa-file"></i> Edit ticket
	        </li>
	</ol>
</div>
@stop