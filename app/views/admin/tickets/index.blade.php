@extends('../../layouts/adminLayout')
@section('content')
<div class="container-fluid">

                <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Avisos
                <small>En este módulo puedes crear, modificar o eliminar avisos</small>
            </h1>

			<div class="row centered-form">
			  	<div class="col-xs-12 col-sm-12 col-md-12">
				    <div class="panel panel-default">

						<br>

						<!-- Button to Create new ticket -->
							<a href="../tickets/create"><button type="submit" class="btn btn-success"><i class="fa fa-lg fa-plus-circle"></i> New Ticket</button></a>
						<br>
						<br>

						<!-- Show errors or success of deleting -->
						<div class="panel-body">
					        @if(Session::get('errors'))
					          	<div class="alert alert-danger alert-dismissable">
					            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					            <h5>Hubo algunos problemas:</h5>
					              {{$errors}}
					          </div>
					        @elseif($success = Session::get('success'))        	
						        <div class="alert alert-success alert-dismissable">
						            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						            <h5>Éxito:</h5>
						          	{{$success}}
					    	    </div>	
					        @endif
					    </div>

						<!-- This table was created with the datatable api -->
						<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					        <thead>
					            <tr>
					                <th>Nombre</th>
					                <th>Cuarto</th>
					                <th>Lugar</th>
					                <th>Hora Salida</th>
					                <th>Hora Entrada</th>
					                <th>Tipo</th>
					                <th>Acción</th>
					            </tr>
					        </thead>
					 
					        <tfoot>
					            <tr>
					                <th>Nombre</th>
					                <th>Cuarto</th>
					                <th>Lugar</th>
					                <th>Hora Salida</th>
					                <th>Hora Entrada</th>
					                <th>Tipo</th>
					                <th>Acción</th>
					            </tr>
					        </tfoot>
					 
					        <tbody>
					        	@foreach($tickets as $ticket)
					        	<tr>
					        		<!-- Ticket Info -->
					                <td>{{$ticket->user->first_name}}</td>
					                <td>{{$ticket->user->room_number}}</td>
					                <td>{{$ticket->place}}</td>
					                <td>{{$ticket->check_in}}</td>
					                <td>{{$ticket->check_out}}</td>

						     	  	<!-- Define the an array with the types of tickets -->
						     	  	{{--*/ $types = array('1' => 'Local', '2' => 'Foráneo', '3' => 'Falta', '4' => 'Fuera de horario') /*--}}

						     	  	<!-- set the ticket type according to the array-->
					                <td>{{$types[$ticket->type]}}</td>
					                <td>
					                	<div class="row">
					                		<div class="col-sm-6 pull-right text-center">
					                			<!-- Form that delete ticket-->
								                {{ Form::open(array('url' => 'tickets/' . $ticket->id)) }}

								                    {{ Form::hidden('_method', 'DELETE') }}
								                    {{ Form::button('<i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="left" title="Eliminar"></i>', array('type' => 'submit', 'class' => 'delete-btn')) }}
								                
								                {{ Form::close() }}
					                		</div>
					                		<div class="col-sm-6 text-center">
					                			<!-- Form that edit ticket-->
						             	   		<a  href="{{ URL::to('tickets/' . $ticket->id . '/edit') }}"> <i class="fa fa-pencil-square-o fa-lg" data-toggle="tooltip" data-placement="left" title="Editar"></i></a>
					                		</div>
					                	</div>	                		                
					            	</td>
					            </tr>
					            @endforeach
					        </tbody>
					    </table>
					    <ol class="breadcrumb">
					    	<li>
					                <i class="fa fa-dashboard"></i>  <a href="../admin">Dashboard</a>
					        </li>
							<li class="active">
								<i class="fa fa-file"></i> Lista de avisos
					        </li>
					    </ol>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
