@extends('layouts/loginLayout')

@section('content')

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading" align="center">
       <!-- <h3 class="panel-title">Please sign in </h3> -->
        <div><img src="images/logoResis.png" class="image-circle"/></div>  
      </div>
      <div class="panel-body">
        @if(Session::get('errors'))
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>There were some errors during login:</h5>
            @foreach($errors->all('<li>:message</li>') as $message)
              {{$message}}
            @endforeach
          </div>
        @endif

        {{ Form::open(array('url' => 'login')) }}
          <div class="form-group">
            {{ Form::text('username', '', array('class'=>'form-control input-sm', 'placeholder' => 'username','maxlength' => 15)) }}
          </div>

          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                {{ Form::password('password', array('class'=>'form-control input-sm', 'placeholder' => 'Password')) }} 
              </div>
            </div>
          </div>

          {{ Form::submit('Sign In', array('class'=>'btn btn-info btn-block')) }}
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@stop