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
                            <h1>Hello there!</h1>
                            <p>
                                This portal will help you to admin the Residence Attendance System. 
                                In the left you can find a navigation bar that will guide you through all the 
                                modules of the system. In each module you will find different posibilities such as create, delete and
                                edit information of each student living in the Residence Hall.
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
            <i class="fa fa-file"></i> Welcome
        </li>
    </ol>
</div>
@stop