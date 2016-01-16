@extends('../layouts/studentLayout')

@section('content')
<div class="row centered-form">
	<div class="panel panel-default">
		<div class="panel-heading" align="center">Lista de Asistencia</div>
      	<div class="panel-body">
      		<!-- Show resume -->
      		@if($msg = Session::get('msg'))
	          	<div class="alert alert-success alert-dismissable">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		            <h5>{{$msg}}</h5>
	          </div>
	        @endif
      		@if($created = Session::get('created'))
	          	<div class="alert alert-success alert-dismissable">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		            <h5>Faltas Creadas:</h5>
		            <ol>
		            @foreach($created as $message)
		              	<li>{{$message}}</li>
		            @endforeach	
		        	</ol>
	          </div>
	        @endif
	        @if($closed = Session::get('closed'))
	        	<div class="alert alert-warning alert-dismissable">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		            <h5>Avisos Cerrados:</h5>
		            <ol>
		            @foreach($closed as $message)
		              	<li>{{$message}}</li>
		            @endforeach
			        </ol>
	          </div>
	        @endif
	        @if($problems = Session::get('problems'))
	        	<div class="alert alert-danger alert-dismissable">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		            <h5>El sistema tuvo problemas con los siguientes:</h5>
		            @foreach($problems as $message)
		              	<li>{{$message}}</li>
		            @endforeach
			        </ol>
	          	</div>
	        @endif
			<!-- Form -->
	        {{ Form::open(array('url' => 'saveAttendance')) }}
				<div class="table-responsive">
				    <table class="table">
				        <thead>
				            <tr>
				                <th>Cuarto</th>
				                <th>Nombre</th>
				                <th>Tipo</th>
				                <th>Crear/Cerrar</th>
				            </tr>
				        </thead>
				        <tbody>
				        	<!-- Create table dinamically -->
				        	@foreach($students as $key => $student)
				            <tr>
				            	<!-- student info -->
				                <td>{{	$student['room_number']	}}</td>
				                <td>{{	$student['name'] 	}}</td>

				                <!-- Set colored labels for each type of ticket-->
				                <td>
				                @if($student['ticket'] == 1)
				                	<span class="label label-info"> 	Local	</span>
				                @elseif($student['ticket'] == 2)
				                	<span class="label label-primary"> 	Foráneo	</span>
				                @elseif($student['ticket'] == 3)
				                	<span class="label label-warning"> 	Falta	</span>
				                @elseif($student['ticket'] == 4)
				                	<span class="label label-danger"> 	Fuera de horario	 </span>	
				               	@else
					               	<span class="label label-success"> 	Ninguno	</span>
				                @endif 
					            </td>

					            <!-- Create form to change student status -->
								<td>
							        <input type="checkbox" name="attendanceList[]" value="{{$student['username']}}" checked>
				                </td>
				            </tr>
				            @endforeach
				        </tbody>
				    </table>
				</div>
	            {{ Form::submit('Guardar', array('class'=>'btn btn-info btn-block')) }}
			</div>
	        {{ Form::close() }}
	    </div>
	</div>
</div>
@stop