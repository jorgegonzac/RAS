@extends('../../layouts/adminLayout')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Dashboard
                <small></small>
            </h1>

            <div class="row centered-form">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-default">
        <!-- Main jumbotron for a primary marketing message or call to action -->
                        <div class="jumbotron">
                            <h1>Bienvenido !!</h1>
                            <p>
                                Este portal le ayudará a administrar el Sistema de Asistencias de Residencias. 
                                En el lado izquierdo se puede encontrar una barra de navegación que 
                                le guiará a través de todos los módulos del sistema. 
                                En cada módulo se encuentran diferentes posibilidades como crear, 
                                eliminar y editar la información de cada estudiante que vive en Residencias.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="admin">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-file"></i> Bienvenido
        </li>
    </ol>
</div>
@stop