@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3>Crear nuevo estudiante</h3>
      </div>
      <div class="panel-body">
        <br>
        <br>

        <!-- Show errors or success of deleting -->
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

          {{ Form::open(array('url' => 'students')) }}
            <div class="row">
              <div class="form-group col-sm-6">
                <label for="firstName"> <h5>Nombre</h5></label>
                {{ Form::text('firstName', '', array('class'=>'form-control input-sm', 'placeholder' => 'Nombre', 'maxlength' => 20, 'required' => 'required')) }}
              </div>

              <div class="form-group col-sm-6">
                <label for="lastName"> <h5>Apellido</h5></label>
                {{ Form::text('lastName', '', array('class'=>'form-control input-sm', 'placeholder' => 'Apellido', 'maxlength' => 20, 'required' => 'required')) }}
              </div>
            </div>
          
            <div class="row">

              <div class="form-group col-sm-4">
                <label for="roomNumber"> <h5>Número de cuarto</h5></label>
                {{ Form::text('roomNumber', '', array('class'=>'form-control input-sm', 'placeholder' => 'Número de cuarto', 'maxlength' => 3, 'required' => 'required')) }}
              </div>

              <div class="form-group col-sm-4">
                <label for="career"> <h5>Carrera</h5></label>
                {{ Form::text('career', '', array('class'=>'form-control input-sm', 'placeholder' => 'Carrera', 'maxlength' => 4, 'required' => 'required')) }}
              </div>

              <div class="form-group col-sm-4">
                <label for="username"> <h5>Matrícula</h5></label>
                {{ Form::text('username', '', array('class'=>'form-control input-sm', 'placeholder' => 'Matrícula', 'maxlength' => 9, 'required' => 'required')) }}
              </div>

            </div>
          <br><br>
              {{ Form::submit('Crear', array('class'=>'btn btn-info btn-block')) }}
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
  <ol class="breadcrumb">
    <li>
      <i class="fa fa-users"></i>  <a href="../students">Estudiantes</a>
    </li>
    <li class="active">
      <i class="fa fa-file"></i> Crear estudiante
    </li>
  </ol>
</div>
@stop
