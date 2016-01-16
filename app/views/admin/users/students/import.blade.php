@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3>Importar lista de estudiantes</h3>
        <h5>Sube un archivo de excel con la lista</h5>
      </div>
      <div class="panel-body">
        <br>
        <br>

        <!-- Show errors or success of deleting -->
        <div class="panel-body">
              @if($errors = Session::get('errors'))
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

          {{ Form::open(array('url' => 'importStudents', 'files'=>true)) }}
            <div class="row text-center">

              <div class="form-group col-sm-4"></div>

              <div class="form-group col-sm-4">
                <label for="file"> <h5>Seleccionar el archivo</h5></label>
                {{ Form::file('file',  ['class'=>'form-control input-sm', 'required' => 'required']) }}
              </div>
              <div class="form-group col-sm-4"></div>
            </div>
            <br>
              {{ Form::submit('Importar', array('class'=>'btn btn-info btn-block')) }}
          {{ Form::close() }}
          <br>

        </div>
      </div>
    </div>
  </div>
  <ol class="breadcrumb">
    <li>
      <i class="fa fa-users"></i>  <a href="../students">Estudiantes</a>
    </li>
    <li class="active">
      <i class="fa fa-file"></i> Importar estudiantes
    </li>
  </ol>
</div>
@stop
