@extends('../layouts/loginLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
      	@if(!$place)
	        <h3 class="panel-title">Please fill the fields </h3> 
	    @else
	        <h3 class="panel-title">You can modify your ticket </h3> 
	    @endif
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
        @elseif($success)
	        <div class="alert alert-success alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h5>Success:</h5>
	              {{$success}}
	          </div>
        @endif

        {{ Form::open(array('url' => 'tickets')) }}
          <div class="form-group">
            {{ Form::text('place', $place, array('class'=>'form-control input-sm', 'placeholder' => 'place', 'maxlength' => 50, 'required' => 'required')) }}
          </div>
          <div class="form-group">
            {{ Form::text('phone', $phone, array('class'=>'form-control input-sm', 'placeholder' => 'phone', 'maxlength' => 10, 'required' => 'required')) }}
          </div>
          <select class="form-control" name="type">
          	@if($type == 2)
		  	  <option value="1">Local</option>
		  	  <option value="2" selected>Foraneo</option>
		  	@else
		  	  <option value="1" selectedb>Local</option>
		  	  <option value="2">Foraneo</option>		  	
		  	@endif
     	  </select>
	      	@if(!$place)
	          {{ Form::submit('Create', array('class'=>'btn btn-info btn-block')) }}
          	@else
	          {{ Form::submit('Save', array('class'=>'btn btn-info btn-block')) }}
          	@endif
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@stop