@extends('../layouts/parentLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
        <h3> My information </h3>
      </div>
      <div class="panel-body">
        <div class="text-center">
              <h4><b>My Name:</b></h4>
              <h3>{{$parent->first_name}} {{$parent->last_name}}</h3>
        </div>
        <br>
        <div class="text-center">
              <h4><b>My Child's Name:</b></h4>
              <h3>{{$son->first_name}} {{$son->last_name}}</h3>
        </div>
         <br>
        <div class="text-center">
              <h4><b>My Child's School ID:</b></h4>
              <h3>{{$son->username}}</h3>
        </div>
         <br>
        <div class="text-center">
              <h4><b>My email:</b></h4>
              <h3>{{$parent->email}}</h3>
        </div>
        
      </div>
    </div>
  </div>
</div>

@stop