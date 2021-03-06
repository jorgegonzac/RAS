@extends('layouts/loginLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <div><img src="../images/logoResis.png" class="image-circle"/></div>  
      </div>
      <div class="panel-body">
        @if($status = Session::get('status'))
          <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{$status}}</h5>
          </div>
        @elseif($error = Session::get('error'))
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>Hubo un error:</h5>
            {{$error}}
          </div>
        @endif
        
        <form action="{{ action('RemindersController@postReset') }}" method="POST">

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="email" name="email" placeholder="Ingresa tu correo" maxlength="50" class="form-control input-sm">
                <input type="password" name="password" placeholder="Nueva contraseña" class="form-control input-sm">
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="form-control input-sm">

                <input type="submit" value="Restaurar contraseña" class="btn btn-info btn-block">

              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

@stop