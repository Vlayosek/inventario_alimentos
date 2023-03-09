<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head_')
</head>

<body class="layout-fixed text-sm layout-navbar-fixed">
    <input type="hidden" id="inicializacion" value="{{ url('/') }}">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('images/loading2.jfif') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        @include('partials.topbar_')
        @include('partials.sidebar_')
        <!-- Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6 titulos_content titulos_content_left hidden">
                            <ol class="breadcrumb float-sm-left">
                                <li class="breadcrumb-item"><a href="#">
                                    </a></li>
                                <li class=" "> @yield('descripcion_general')
                                </li>
                            </ol>
                        </div><!-- /.col -->
                        <div class="col-sm-6 titulos_content">
                            <h1 class="m-0"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 titulos_content titulos_content_right">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">
                                    </a></li>
                                <li class=" " style="color: #278fce;"> @yield('descripcion_detalle')
                                </li>
                            </ol>
                        </div><!-- /.col -->
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-12">

                                </div>
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </div>

                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('partials.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('partials.javascripts_')
</body>

</html>
