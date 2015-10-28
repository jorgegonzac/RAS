@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3>Edit parent</h3>
      </div>
      <div class="panel-body">
        <br>
        <br>

        <!-- Show errors or success of creating -->
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

		{{ Form::model($user, array('method' => 'PATCH', 'route' => array('parents.update', $user->id))) }}
            <div class="row">
              <div class="form-group col-sm-6">
                <label for="firstName"> <h5>First Name</h5></label>
                {{ Form::text('firstName', $user->first_name, array('class'=>'form-control input-sm', 'placeholder' => 'First Name', 'maxlength' => 20, 'required' => 'required')) }}
              </div>

              <div class="form-group col-sm-6">
                <label for="lastName"> <h5>Last Name</h5></label>
                {{ Form::text('lastName', $user->last_name, array('class'=>'form-control input-sm', 'placeholder' => 'Last Name', 'maxlength' => 20, 'required' => 'required')) }}
              </div>
            </div>
          
            <div class="row">

              <div class="form-group col-sm-4">
				<label for="schoolID"> <h5>Son's ID</h5></label>
	            {{ Form::text('schoolID', $son->username, array('class'=>'form-control input-sm', 'placeholder' => 'School ID', 'maxlength' => 9, 'required' => 'required')) }}
	          </div>

              <div class="form-group col-sm-4">
                <label for="username"> <h5>Username</h5></label>
                {{ Form::text('username', $user->username, array('class'=>'form-control input-sm', 'placeholder' => 'Username', 'maxlength' => 9, 'required' => 'required')) }}
              </div>

              <div class="form-group col-sm-4">
                <label for="email"> <h5>Email</h5></label>
                {{ Form::text('email', $user->email, array('class'=>'form-control input-sm', 'placeholder' => 'Email', 'maxlength' => 50, 'required' => 'required')) }}
              </div>

            </div>

            </div>
          <br>
              {{ Form::submit('Save', array('class'=>'btn btn-info btn-block')) }}
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
  <ol class="breadcrumb">
    <li>
      <i class="fa fa-users"></i>  <a href="../../parents">Parents</a>
    </li>
    <li class="active">
      <i class="fa fa-file"></i> Edit parent
    </li>
  </ol>
</div>
@stop
