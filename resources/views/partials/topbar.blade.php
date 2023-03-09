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
    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            {{-- <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span> --}}
            <i class="fa fa-fw fa-bars"></i>
        </a>
        <span class="sidebar-toggle">CONSULTORIO MÉDICO DE LA PRESIDENCIA DE LA REPÚBLICA</span>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->

                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    @if (session('impersonated_by'))
                        <li class="navbar-nav  ">
                            <a href="{{ url('/impersonate_leave') }}" class="nav-link">
                                <p style="color:#000">
                                    REGRESAR A MI USUARIO
                                </p>
                            </a>
                        </li>
                    @endif
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->

                        <a class="dropdown-toggle" style="min-height: 50px;">
                            <!-- The user image in the navbar-->
                            @if (empty(Auth::user()->foto))
                                <img src="{{ asset('/img/avatar_plusis.png') }}" class="user-image" alt="User Image" />
                            @else
                                <img src="{{ asset('/storage/USUARIOS/') . '/' . Auth::user()->foto }}" class="user-image"
                                    alt="User Image" />
                            @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"></span>

                        </a>

                        <ul class="dropdown-menu">

                            <!-- The user image in the menu -->
                            <li class="user-header">
                                @if (empty(Auth::user()->foto))
                                    <img src="{{ asset('/img/avatar_plusis.png') }}" class="img-circle"
                                        alt="User Image" />
                                @else
                                    <img src="{{ asset('/storage/USUARIOS/') . '/' . Auth::user()->foto }}"
                                        class="img-image" alt="User Image" />
                                @endif

                                <p>
                                    <span>{{ Auth::user()->name }}</span>
                          
                                </p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                    <a href="{{ url('/logout') }}" id="cerrar"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                        id='cerrars' class="btn btn-default btn-flat btn-sm btn-block">
                                        Cerrar Sesi&oacute;n
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                    </form>


                            </li>

                        </ul>
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button -->

            </ul>
        </div>
    </nav>
</header>
