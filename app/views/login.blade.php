@extends('layouts/loginLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <div><img src="../images/logoResis.png" class="image-circle"/></div>  
      </div>
      <div class="panel-body">
        @if(Session::get('errors'))
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>Hubo algunos errores durante el inicio de sesión:</h5>
            @foreach($errors->all('<li>:message</li>') as $message)
              {{$message}}
            @endforeach
          </div>
        @endif

        {{ Form::open(array('url' => 'login')) }}

          <div class="form-group">
            {{ Form::text('username', '', array('class'=>'form-control input-sm', 'placeholder' => 'Usuario','maxlength' => 15)) }}
          </div>

          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                {{ Form::password('password', array('class'=>'form-control input-sm', 'placeholder' => 'Contraseña')) }} 
              </div>
            </div>
          </div>

          {{ Form::submit('Iniciar sesión', array('class'=>'btn btn-info btn-block')) }}
        {{ Form::close() }}

        <a href="/password/remind">¿Olvidaste tu contraseña ?</a>
      </div>
    </div>
  </div>
</div>

@stop