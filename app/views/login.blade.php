<!-- app/views/login.blade.php -->

<!doctype html>
<html>
<head>
<title>Residence Attendance System</title>
</head>
<body>

{{ Form::open(array('url' => 'login')) }}
<h1>Login</h1>

<p>
    {{ $errors->first('username') }}
    {{ Form::label('username', 'Matricula:') }}
    {{ Form::text('username', '', array('placeholder' => 'A00123456','maxlength' => 9)) }}
</p>

<p>
    {{ $errors->first('password') }}
    {{ Form::label('password', 'Contraseña:') }}
    {{ Form::password('password', array('placeholder' => '************')) }}                       
</p>
<p>
	{{ $errors->first('system')}}
</p>
<p>{{ Form::submit('Ingresar') }}</p>
{{ Form::close() }}