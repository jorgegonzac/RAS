@extends('../layouts/parentLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
      	<h3>Avisos</h3>
      </div>
      <div class="panel-body">

        <!-- This table was created with the datatable api -->
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Lugar</th>
                    <th>Teléfono</th>
                    <th>Hora de entrada</th>
                    <th>Hora de salida</th>
                    <th>Tipo de aviso</th>
                </tr>
            </thead>
     
            <tfoot>
                <tr>
                    <th>Lugar</th>
                    <th>Teléfono</th>
                    <th>Hora de entrada</th>
                    <th>Hora de salida</th>
                    <th>Tipo de aviso</th>
                </tr>
            </tfoot>
     
            <tbody>
              @foreach($tickets as $ticket)
              <tr>
                <!-- Ticket Info -->
                    <td>{{$ticket->place}}</td>
                    <td>{{$ticket->phone}}</td>
                    <td>{{$ticket->check_in}}</td>
                    <td>{{$ticket->check_out}}</td>

                <!-- Define the an array with the types of tickets -->
                {{--*/ $types = array('1' => 'Local', '2' => 'Foráneo', '3' => 'Falta', '4' => 'Fuera de horario') /*--}}

                <!-- set the ticket type according to the array-->
                    <td>{{$types[$ticket->type]}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

      </div>
    </div>
  </div>
</div>

@stop