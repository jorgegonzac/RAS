@extends('layouts/parentCreateAccountLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
       	<h3 class="panel-title">Create a new account ! </h3>
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
		        <h5>Congratulations!:</h5>
		        {{$success}}
            <h5>You can go now to <a href="login"><h3>login</h3></a></h5>
	    	</div>
        @endif

        {{ Form::open(array('url' => 'createAccount')) }}
          <div class="form-group">
			<label for="username"> <h5>Choose your username (max 9 characteres)</h5></label>
            {{ Form::text('username', '', array('class'=>'form-control input-sm', 'placeholder' => '', 'maxlength' => 9, 'required' => 'required')) }}
          </div>
		  
		  <div class="form-group">
			<label for="schoolID"> <h5>Your son's ID</h5></label>
            {{ Form::text('schoolID', '', array('class'=>'form-control input-sm', 'placeholder' => '', 'maxlength' => 9, 'required' => 'required')) }}
          </div>

		  <div class="form-group">
			<label for="firstName"> <h5>Your first name</h5></label>
            {{ Form::text('firstName', '', array('class'=>'form-control input-sm', 'placeholder' => '', 'maxlength' => 20, 'required' => 'required')) }}
          </div>

		  <div class="form-group">
			<label for="lastName"> <h5>Your last name</h5></label>
            {{ Form::text('lastName', '', array('class'=>'form-control input-sm', 'placeholder' => '', 'maxlength' => 20, 'required' => 'required')) }}
          </div>

		  <div class="form-group">
			<label for="email"> <h5>Your email</h5></label>
            {{ Form::text('email', '', array('class'=>'form-control input-sm', 'placeholder' => '', 'maxlength' => 50, 'required' => 'required')) }}
          </div>

          <div class="form-group">
			<label for="password"> <h5>Create a password</h5></label>
            {{ Form::password('password', array('class'=>'form-control input-sm', 'placeholder' => '', 'maxlength' => 20, 'required' => 'required')) }} 
          </div>
		  
		  <div class="form-group">
			<label for="passwordConfirm"> <h5>Confirm your password</h5></label>
            {{ Form::password('passwordConfirm', array('class'=>'form-control input-sm', 'placeholder' => '', 'maxlength' => 20, 'required' => 'required')) }} 
          </div>

          {{ Form::submit('Sign Up', array('class'=>'btn btn-info btn-block')) }}
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@stop