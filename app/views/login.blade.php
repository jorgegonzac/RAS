<!-- app/views/login.blade.php -->

<!doctype html>
<html>
<head>
<title>Look at me Login</title>
</head>
<body>

{{ Form::open(array('url' => 'login')) }}
<h1>Login</h1>

<!-- if there are login errors, show them here -->
<p>
    {{ $errors->first('school_id') }}
    {{ $errors->first('password') }}
</p>

<p>
    {{ Form::label('school_id', 'Matricula:') }}
    {{ Form::text('school_id', '', array('placeholder' => 'A00123456','maxlength' => 9)) }}
</p>

<p>
    {{ Form::label('password', 'Contraseña:') }}
    {{ Form::password('password', array('placeholder' => '************')) }}                       
</p>

<p>{{ Form::submit('Ingresar') }}</p>
{{ Form::close() }}