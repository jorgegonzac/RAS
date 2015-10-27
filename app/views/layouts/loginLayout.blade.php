<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Residence Attendance System</title>

    <!-- Bootstrap CSS served from a CDN -->
    <link href="//netdna.bootstrapcdn.com/bootswatch/3.1.0/superhero/bootstrap.min.css"
          rel="stylesheet">
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

    <div class="container">
      @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
  </body>
</html>