@extends('../../layouts/adminLayout')
@section('content')

<div class="container-fluid">
   <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Create Disciplinary Report
                <small></small>
            </h1>
	    <div>
    <div>

	<div class="row centered-form">
	  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
	    <div class="panel panel-default">
	      <div class="panel-heading" align="center">
		    <h3 class="panel-title">Please fill the fields </h3> 
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
	          	<div class="form-group">
	            	{{ Form::text('username', '', array('class'=>'form-control input-sm', 'placeholder' => 'username', 'maxlength' => 9, 'required' => 'required')) }}
	          	</div>
	          	<div class="form-group">
	            	{{ Form::textarea('description', '', array('class'=>'textarea-editable', 'rows' => 8, 'placeholder' => 'Description', 'maxlength' => 300, 'required' => 'required')) }}
	          	</div>
				
	     	  	<br>	

				<label for="date"> <h5>Date</h5></label>
		     	<input name="date" id="date" class="date input-sm"> </input>
	     	  	
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
	                <i class="fa fa-list-ol"></i>  <a href="../dReports">Disciplinary Reports</a>
	        </li>
			<li class="active">
				<i class="fa fa-file"></i> Create Disciplinary Report
	        </li>
	</ol>
</div>
@stop