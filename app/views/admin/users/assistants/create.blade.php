@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3>Registrar nuevo prefecto</h3>
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

          <!-- Form to create assistant-->
          {{ Form::open(array('url' => 'assistants')) }}
                      
            <div class="row">
	            <div class="form-group col-sm-4"></div>

	            <div class="form-group col-sm-4">
	               <label for="username"> <h5>Matrícula</h5></label>
	                {{ Form::text('username', '', array('class'=>'form-control input-sm', 'placeholder' => 'Matrícula', 'maxlength' => 9, 'required' => 'required')) }}
	            </div>

	            <div class="form-group col-sm-4"></div>

	        </div>
          	<br><br>
            <div class="row">
            <div class="form-group col-sm-4"></div>
            
            <div class="form-group col-sm-4">
				{{ Form::submit('Registrar', array('class'=>'btn btn-info btn-block')) }}
          {{ Form::close() }}
            </div>
            
	        <div class="form-group col-sm-4"></div>
	        </div>

        </div>
      </div>
    </div>
  </div>
  <ol class="breadcrumb">
    <li>
      <i class="fa fa-users"></i>  <a href="../assistants">Prefectos</a>
    </li>
    <li class="active">
      <i class="fa fa-file"></i> Registrar nuevo prefecto
    </li>
  </ol>
</div>
@stop
