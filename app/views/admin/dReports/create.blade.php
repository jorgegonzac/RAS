@extends('../../layouts/adminLayout')
@section('content')

<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3>Create New Disciplinary Report</h3>
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

	        {{ Form::open(array('url' => 'dReports')) }}
	        	<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="username"> <h5>Username</h5></label>
		            	{{ Form::text('username', '', array('class'=>'form-control input-sm', 'placeholder' => 'username', 'maxlength' => 9, 'required' => 'required')) }}
		          	</div>

	        		<div class="col-sm-6 form-group">
						<label for="date"> <h5>Date</h5></label>
				     	<input name="date" id="date" class="date form-control input-sm"> </input>
	        		</div>
	        	</div>

	          	<div class="form-group">
					<label for="description"> <h5>Description</h5></label>
	            	{{ Form::textarea('description', '', array('class'=>'textarea-editable', 'rows' => 8, 'placeholder' => 'Description', 'maxlength' => 300, 'required' => 'required')) }}
	          	</div>
					     	  	
	     	  	<br>	
		          {{ Form::submit('Create', array('class'=>'btn btn-info btn-block')) }}
	        {{ Form::close() }}
	      </div>
	    </div>
	  </div>
	</div>
	<ol class="breadcrumb">
	    	<li>
	                <i class="fa fa-file-text"></i>  <a href="../dReports">Disciplinary Reports</a>
	        </li>
			<li class="active">
				<i class="fa fa-file"></i> Create Disciplinary Report
	        </li>
	</ol>
</div>
@stop