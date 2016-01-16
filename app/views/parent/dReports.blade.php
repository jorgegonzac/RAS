@extends('../layouts/parentLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
      	<h3>Reportes disciplinarios</h3>
      </div>
      <div class="panel-body">

        <!-- This table was created with the datatable api -->
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Fecha</th>
                </tr>
            </thead>
     
            <tfoot>
                <tr>
                    <th>Descripción</th>
                    <th>Fecha</th>
                </tr>
            </tfoot>
     
            <tbody>
              @foreach($dReports as $dReport)
              <tr>
                <!-- Disciplinary Report Info -->
                    <td>{{$dReport->description}}</td>
                    <td>{{$dReport->date}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

      </div>
    </div>
  </div>
</div>

@stop