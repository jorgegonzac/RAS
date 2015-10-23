<!-- Datatable files -->
    <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RAS - Admin portal</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Datatime picker CSS-->
    <link rel="stylesheet" type="text/css" href="../../css/jquery.filthypillow.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="admin">RAS Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> 
                            <!-- Get user name from the session data -->
                            {{Auth::user()->first_name}} 
                                <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../../logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="../../admin"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="../../takeAttendance"><i class="fa fa-fw fa-list-ol"></i> Take Attendance</a>
                    </li>
                    <li>
                        <a href="../../tickets"><i class="fa fa-fw fa-list-ol"></i> Tickets</a>
                    </li>
                    <li>
                        <a href="charts.html"><i class="fa fa-fw fa-bar-chart-o"></i> Reports </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Students</a>
                            </li>
                            <li>
                                <a href="#">Resident Assistants</a>
                            </li>
                            <li>
                                <a href="#">Parents</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="../../dReports"><i class="fa fa-fw fa-edit"></i> Disciplinary Reports</a>
                    </li>
                    <li>
                        <a href="bootstrap-elements.html"><i class="fa fa-fw fa-cogs"></i> Settings </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <!-- All the dynamic content goes here -->
        <div id="page-wrapper">
            @yield('content')            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../js/bootstrap.min.js"></script>

    <!-- Datatable files -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs/jqc-1.11.3,dt-1.10.9,fc-3.1.0,r-1.0.7,sc-1.3.0/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/r/bs/jqc-1.11.3,dt-1.10.9,fc-3.1.0,r-1.0.7,sc-1.3.0/datatables.min.js"></script>
    
    <!-- datetime picker JS files -->
    <script type="text/javascript" src="../../js/moment.js"></script>
    <script type="text/javascript" src="../../js/jquery.filthypillow.js"></script>
  

    <!-- script to starts-->
    <script type="text/javascript">
        $(document).ready(function() {
            // start the datatable
            $('#table').DataTable();

            // start datetime picker check_in
            var $fp = $( ".check-in" );

            // Set the minimun date time that will be available
            $fp.filthypillow( {
                minDateTime: function( ) {
                return moment( ).subtract( "days", 200 ); //now
            }   

            // Show datatime picker when focus
            } );
            $fp.on( "focus", function( ) {
                $fp.filthypillow( "show" );
                } );

            // Set datatime format
            $fp.on( "fp:save", function( e, dateObj ) {
                $fp.val( dateObj.format( "YYYY-MM-DD HH:mm:ss" ) );
                $fp.filthypillow( "hide" );
                } );   

        // start datetime picker check_out
            var $fp2 = $( ".check-out" );

            // Set the minimun date time that will be available
            $fp2.filthypillow( {
                minDateTime: function( ) {
                return moment( ).subtract( "days", 200 ); //now
            }   

            // Show datatime picker when focus
            } );
            $fp2.on( "focus", function( ) {
                $fp2.filthypillow( "show" );
                } );

            // Set datatime format
            $fp2.on( "fp:save", function( e, dateObj ) {

                $fp2.filthypillow( "hide" );
                $fp2.val( dateObj.format( "YYYY-MM-DD HH:mm:ss" ) );
                } );   

        // start datetime picker date (reports)
            var $fp2 = $( ".date" );

            // Set the minimun date time that will be available
            $fp2.filthypillow( {
                minDateTime: function( ) {
                return moment( ).subtract( "days", 200 ); //now
            }   

            // Show datatime picker when focus
            } );
            $fp2.on( "focus", function( ) {
                $fp2.filthypillow( "show" );
                } );

            // Set datatime format
            $fp2.on( "fp:save", function( e, dateObj ) {

                $fp2.filthypillow( "hide" );
                $fp2.val( dateObj.format( "YYYY-MM-DD HH:mm:ss" ) );
                } );           
        } );
    </script>

</body>

</html>
