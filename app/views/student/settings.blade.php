@extends('../layouts/studentLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
	        <h3 class="panel-title"> Información de cuenta </h3> 
      </div>
      <div class="panel-body">
        @if(Session::get('errors'))
            <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>Hubo algunos errores:</h5>
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

        {{ Form::open(array('url' => 'settings')) }}
          <div class="form-group">
            <label for="email"> <h5>Correo</h5></label>
            <input type="email" name="email" value="{{$user->email}}" placeholder="Ingresa tu correo" maxlength="50" class="form-control input-sm">
          </div>
          <div class="form-group">
            <label for="password"> <h5>Nueva Contraseña</h5></label>
            <input type="password" name="password" placeholder="Nueva Contraseña" class="form-control input-sm">
          </div>
          <div class="form-group">
            <label for="passwordConfirmation"> <h5>Confirmar Contraseña</h5></label>
            <input type="password" name="passwordConfirmation" placeholder="Confirmar Contraseña" class="form-control input-sm">
          </div>

	          {{ Form::submit('Save', array('class'=>'btn btn-info btn-block')) }}

        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@stop