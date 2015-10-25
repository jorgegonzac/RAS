@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3>Edit the user</h3>
      </div>
      <div class="panel-body">
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

		{{ Form::model($user, array('method' => 'PATCH', 'route' => array('students.update', $user->id))) }}
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
                <label for="roomNumber"> <h5>Room Number</h5></label>
                {{ Form::text('roomNumber', $user->room_number, array('class'=>'form-control input-sm', 'placeholder' => 'Room Number', 'maxlength' => 3, 'required' => 'required')) }}
              </div>

              <div class="form-group col-sm-4">
                <label for="career"> <h5>Career</h5></label>
                {{ Form::text('career', $user->career, array('class'=>'form-control input-sm', 'placeholder' => 'Career', 'maxlength' => 4, 'required' => 'required')) }}
              </div>

              <div class="form-group col-sm-4">
                <label for="username"> <h5>School ID</h5></label>
                {{ Form::text('username', $user->username, array('class'=>'form-control input-sm', 'placeholder' => 'School ID', 'maxlength' => 9, 'required' => 'required')) }}
              </div>

            </div>
          <br><br>
              {{ Form::submit('Save', array('class'=>'btn btn-info btn-block')) }}
          {{ Form::close() }}

          <ol class="breadcrumb">
            <li>
              <i class="fa fa-dashboard"></i>  <a href="../../students">Students</a>
            </li>
            <li class="active">
              <i class="fa fa-file"></i> Create Student
            </li>
          </ol>

        </div>
      </div>
    </div>
  </div>
</div>
@stop
