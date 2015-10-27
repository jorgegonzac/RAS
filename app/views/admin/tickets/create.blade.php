@extends('../../layouts/adminLayout')
@section('content')

<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3>Create New Ticket</h3>
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

	        {{ Form::open(array('url' => 'adminTickets')) }}
	        	<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="username"> <h5>Username</h5></label>
		            	{{ Form::text('username', '', array('class'=>'form-control input-sm', 'placeholder' => 'username', 'maxlength' => 9, 'required' => 'required')) }}
		          	</div>
	        		<div class="col-sm-6 form-group">
						<label for="place"> <h5>Place</h5></label>
		            	{{ Form::text('place', '', array('class'=>'form-control input-sm', 'placeholder' => 'place', 'maxlength' => 50, 'required' => 'required')) }}
		          	</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="phone"> <h5>Phone</h5></label>
		            	{{ Form::text('phone', '', array('class'=>'form-control input-sm', 'placeholder' => 'phone', 'maxlength' => 10, 'required' => 'required')) }}
		          	</div>

	        		<div class="col-sm-6 form-group">
						<label for="type"> <h5>Type</h5></label>
			          	<select class="form-control input-sm" name="type">
					  	  <option value="1" selected>Local</option>
					  	  <option value="2">Foreign</option>
					  	  <option value="3">Absence</option>
					  	  <option value="4">Out of time</option>
			     	  	</select>		
		          	</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="check-in"> <h5>Check-in</h5></label>
		            	{{ Form::text('check-in', '', array('class'=>'check-in form-control input-sm', 'id' =>'check-in', 'required' => 'required')) }}
		          	</div>
	        		<div class="col-sm-6 form-group">
						<label for="check-out"> <h5>Check-out</h5></label>
		            	{{ Form::text('check-out', '', array('class'=>'check-out form-control input-sm', 'id' =>'check-out', 'required' => 'required')) }}
		          	</div>
	        	</div>
	     	  	
	     	  	<br>	
	          	<br>
		          {{ Form::submit('Create', array('class'=>'btn btn-info btn-block')) }}
	        {{ Form::close() }}
	      </div>
	    </div>
	  </div>
	</div>
	<ol class="breadcrumb">
	    	<li>
	                <i class="fa fa-edit"></i>  <a href="../tickets">Tickets</a>
	        </li>
			<li class="active">
				<i class="fa fa-file"></i> Create tickets
	        </li>
	</ol>
</div>
@stop