@extends('../layouts/studentLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
	        <h3 class="panel-title"> Account info </h3> 
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

        {{ Form::open(array('url' => 'settings')) }}
          <div class="form-group">
            <label for="email"> <h5>Email</h5></label>
            <input type="email" name="email" value="{{$user->email}}" placeholder="Enter your email" maxlength="50" class="form-control input-sm">
          </div>
          <div class="form-group">
            <label for="password"> <h5>Password</h5></label>
            <input type="password" name="password" placeholder="New password" class="form-control input-sm">
          </div>
          <div class="form-group">
            <label for="passwordConfirmation"> <h5>Confirm password</h5></label>
            <input type="password" name="passwordConfirmation" placeholder="Password confirmation" class="form-control input-sm">
          </div>

	          {{ Form::submit('Save', array('class'=>'btn btn-info btn-block')) }}

        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@stop