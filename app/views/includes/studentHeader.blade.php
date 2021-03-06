<!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"> RAS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav menu">
                    <li>
                        <a href="../student">Avisos</a>
                    </li>
                    @if(Session::get('role') == 2)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i> 
                                Pasar Lista
                                    <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">

                        @if(Session::get('room_number') < 300)
                            <li>
                                <a href="../../takeAttendanceByFloor/1"><i class="fa fa-fw fa-list-ol"></i> Piso 1</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="../../takeAttendanceByFloor/2"><i class="fa fa-fw fa-list-ol"></i> Piso 2</a>
                            </li>
                        @else
                            <li>
                                <a href="../../takeAttendanceByFloor/3"><i class="fa fa-fw fa-list-ol"></i> Piso 3</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="../../takeAttendanceByFloor/4"><i class="fa fa-fw fa-list-ol"></i> Piso 4</a>
                            </li>
                        @endif

                        </ul>
                    </li>                    
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i> 
                                <!-- Get user name from the session data -->
                                {{Auth::user()->first_name}} 
                                    <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="../settings"><i class="fa fa-fw fa-gear"></i> Configuración</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="../logout"><i class="fa fa-fw fa-power-off"></i> Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>