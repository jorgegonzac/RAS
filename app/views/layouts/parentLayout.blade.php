<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Residence Attendance System</title>

    <!-- Bootstrap CSS served from a CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/cosmo/bootstrap.min.css"
          rel="stylesheet">

    <!-- More themes at https://www.bootstrapcdn.com/bootswatch/-->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

    <!-- Bootstrap JS-->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

    <!-- Custom Fonts -->
    <link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Datatable files -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs/jqc-1.11.3,dt-1.10.9,fc-3.1.0,r-1.0.7,sc-1.3.0/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/r/bs/jqc-1.11.3,dt-1.10.9,fc-3.1.0,r-1.0.7,sc-1.3.0/datatables.min.js"></script>

    <style>
    body{
      background: url("images/background/fabric_of_squares_gray.png");
    }

    .centered-form .panel{
      background: rgba(255, 255, 255, 0.8);
      box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
      color: #4e5d6c;
    }

    .image-circle{
      border-radius: 50%;
      width: 175px;
      height: 175px;
      border: 4px solid #FFF;
      margin: 10px;
    }
    .outter{
      padding: 0px;
      border: 1px solid rgba(255, 255, 255, 0.29);
      border-radius: 50%;
      width: 200px;
      height: 200px;
    }
    .centered-form{
      margin-top: 60px;
    }


    </style>
  </head>

  <body>
    @include('includes.parentHeader')

    <div class="container">
      @yield('content')
    </div>

    <!-- script to start datatable-->
    <script type="text/javascript">

        $(document).ready(function() {
            // start the datatable
            $('#table').DataTable();
        } );

    </script>


  </body>
</html>