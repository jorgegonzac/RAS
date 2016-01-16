@extends('../../layouts/adminLayout')
@section('content')

<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3>Crear aviso</h3>
      </div>
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

	        {{ Form::open(array('url' => 'adminTickets')) }}
	        	<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="username"> <h5>Matrícula</h5></label>
		            	{{ Form::text('username', '', array('class'=>'form-control input-sm', 'placeholder' => 'Matrícula', 'maxlength' => 9, 'required' => 'required')) }}
		          	</div>
	        		<div class="col-sm-6 form-group">
						<label for="place"> <h5>Lugar</h5></label>
		            	{{ Form::text('place', '', array('class'=>'form-control input-sm', 'placeholder' => 'Lugar', 'maxlength' => 50, 'required' => 'required')) }}
		          	</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="phone"> <h5>Teléfono</h5></label>
		            	{{ Form::text('phone', '', array('class'=>'form-control input-sm', 'placeholder' => 'Teléfono', 'maxlength' => 10, 'required' => 'required')) }}
		          	</div>

	        		<div class="col-sm-6 form-group">
						<label for="type"> <h5>Tipo</h5></label>
			          	<select class="form-control input-sm" name="type">
					  	  <option value="1" selected>Local</option>
					  	  <option value="2">Foráneo</option>
					  	  <option value="3">Falta</option>
					  	  <option value="4">Fuera de horario</option>
			     	  	</select>		
		          	</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-sm-6 form-group">
						<label for="check-in"> <h5>Hora Salida</h5></label>
		            	{{ Form::text('check-in', '', array('class'=>'check-in form-control input-sm', 'id' =>'check-in', 'required' => 'required')) }}
		          	</div>
	        		<div class="col-sm-6 form-group">
						<label for="check-out"> <h5>Hora Entrada</h5></label>
		            	{{ Form::text('check-out', '', array('class'=>'check-out form-control input-sm', 'id' =>'check-out', 'required' => 'required')) }}
		          	</div>
	        	</div>
	     	  	
	     	  	<br>	
	          	<br>
		          {{ Form::submit('Crear', array('class'=>'btn btn-info btn-block')) }}
	        {{ Form::close() }}
	      </div>
	    </div>
	  </div>
	</div>
	<ol class="breadcrumb">
	    	<li>
	                <i class="fa fa-edit"></i>  <a href="../tickets">Avisos</a>
	        </li>
			<li class="active">
				<i class="fa fa-file"></i> Crear aviso
	        </li>
	</ol>
</div>
@stop