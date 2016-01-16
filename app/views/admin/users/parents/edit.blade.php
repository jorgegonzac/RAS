@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3>Editar padre</h3>
      </div>
      <div class="panel-body">
        <br>
        <br>

        <!-- Show errors or success of creating -->
        <div class="panel-body">
              @if(Session::get('errors'))
                  <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5>Hubo algunos problemas:</h5>
                  @foreach($errors->all('<li>:message</li>') as $message)
                    {{$message}}
                  @endforeach
                </div>
              @elseif($success = Session::get('success'))         
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5>Éxito:</h5>
                    {{$success}}
                </div>  
              @endif
          </div>

		{{ Form::model($user, array('method' => 'PATCH', 'route' => array('parents.update', $user->id))) }}
            <div class="row">
              <div class="form-group col-sm-6">
                <label for="firstName"> <h5>Nombre</h5></label>
                {{ Form::text('firstName', $user->first_name, array('class'=>'form-control input-sm', 'placeholder' => 'Nombre', 'maxlength' => 20, 'required' => 'required')) }}
              </div>

              <div class="form-group col-sm-6">
                <label for="lastName"> <h5>Apellido</h5></label>
                {{ Form::text('lastName', $user->last_name, array('class'=>'form-control input-sm', 'placeholder' => 'Apellido', 'maxlength' => 20, 'required' => 'required')) }}
              </div>
            </div>
          
            <div class="row">

              <div class="form-group col-sm-4">
				<label for="schoolID"> <h5>Matrícula de su hijo/a</h5></label>
	            {{ Form::text('schoolID', $son->username, array('class'=>'form-control input-sm', 'placeholder' => 'Matrícula', 'maxlength' => 9, 'required' => 'required')) }}
	          </div>

              <div class="form-group col-sm-4">
                <label for="username"> <h5>Nombre de usuario</h5></label>
                {{ Form::text('username', $user->username, array('class'=>'form-control input-sm', 'placeholder' => 'Usuario', 'maxlength' => 9, 'required' => 'required')) }}
              </div>

              <div class="form-group col-sm-4">
                <label for="email"> <h5>Correo electrónico</h5></label>
                {{ Form::text('email', $user->email, array('class'=>'form-control input-sm', 'placeholder' => 'Correo electrónico', 'maxlength' => 50, 'required' => 'required')) }}
              </div>

            </div>

            </div>
          <br>
              {{ Form::submit('Guardar', array('class'=>'btn btn-info btn-block')) }}
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
  <ol class="breadcrumb">
    <li>
      <i class="fa fa-users"></i>  <a href="../../parents">Padres</a>
    </li>
    <li class="active">
      <i class="fa fa-file"></i> Editar padre
    </li>
  </ol>
</div>
@stop
