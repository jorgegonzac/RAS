@extends('../layouts/studentLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
      	@if(!$place)
	        <h3 class="panel-title">Porfavor llena todos los campos </h3> 
	    @else
	        <h3 class="panel-title">Tienes un aviso abierto, puedes modificarlo </h3> 
	    @endif
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
        @elseif($success)
        	@if($type == 4)
		        <div class="alert alert-warning alert-dismissable">
	            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            	<h5>Advertencia:</h5>
	              	{{$success}}
	          	</div>
        	@else
	        	<div class="alert alert-success alert-dismissable">
	            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            	<h5>Éxito:</h5>
	              	{{$success}}
    	        </div>
	        @endif
        @endif

        {{ Form::open(array('url' => 'tickets')) }}
          <div class="form-group">
            {{ Form::text('place', $place, array('class'=>'form-control input-sm', 'placeholder' => 'Lugar', 'maxlength' => 50, 'required' => 'required')) }}
          </div>
          <div class="form-group">
            {{ Form::text('phone', $phone, array('class'=>'form-control input-sm', 'placeholder' => 'Teléfono (10 dígitos)', 'maxlength' => 10, 'required' => 'required')) }}
          </div>
          <select class="form-control" name="type">
          	@if($type == 2)
		  	  <option value="1">Local</option>
		  	  <option value="2" selected>Foráneo</option>
		  	@elseif($type == 4)	  	
		  	  <option value="4" selectedb>Fuera de horario</option>
		  	@else
		  		<option value="1" selectedb>Local</option>
		  	  	<option value="2">Foráneo</option>	
		  	@endif
     	  </select>
	      	@if(!$place)
	          {{ Form::submit('Crear Aviso', array('class'=>'btn btn-info btn-block')) }}
          	@else
	          {{ Form::submit('Guardar Cambios', array('class'=>'btn btn-info btn-block')) }}
          	@endif
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@stop