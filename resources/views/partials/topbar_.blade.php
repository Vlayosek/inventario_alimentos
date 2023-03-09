<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/admin/home') }}" class="logo" style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            SMD</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            SIDMED</span>
    </a>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item">
                <span class="nav-link">CONSULTORIO MÉDICO DE LA PRESIDENCIA DE LA REPÚBLICA</span>

            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">



            @if (session('impersonated_by'))
                <li class="nav-item">
                    <a href="{{ url('/impersonate_leave') }}" class="nav-link">
                        <p style="color:#000">
                            REGRESAR A MI USUARIO
                        </p>
                    </a>
                </li>
            @endif
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    @if (empty(Auth::user()->foto))
                        <img src="{{ asset('/img/avatar_plusis.png') }}" class="user-image img-circle elevation-2"
                            alt="User Image" />
                    @else
                        <img src="{{ asset('/storage/USUARIOS/') . '/' . Auth::user()->foto }}"
                            class="user-image img-circle elevation-2" alt="User Image" />
                    @endif
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-info">
                        @if (empty(Auth::user()->foto))
                            <img src="{{ asset('/img/avatar_plusis.png') }}" class="img-circle elevation-2"
                                alt="User Image" />
                        @else
                            <img src="{{ asset('/storage/USUARIOS/') . '/' . Auth::user()->foto }}"
                                class="img-circle elevation-2" alt="User Image" />
                        @endif
                        <p>
                            {{ Auth::user()->name }}
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ url('/logout') }}" id="cerrar"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                            id='cerrars' class="btn btn-default btn-flat btn-sm btn-block">
                            Cerrar Sesi&oacute;n
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
            <li class="nav-item hidden">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item hidden">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
</header>
