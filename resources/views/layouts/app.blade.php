<!DOCTYPE html>
<html lang="en">

<head>

    @include('partials.head')
</head>

<body class="hold-transition skin-blue sidebar-mini">
  

    <div id="wrapper">

        @include('partials.topbar')
        @include('partials.sidebar_')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                @if (isset($siteTitle))
                    <h3 class="page-title">
                        {{ $siteTitle }}
                    </h3>
                @endif

                <div class="row" style="margin-top: 50px;">
                    <div class="col-md-12">

                        @if (Session::has('message'))
                            <div class="note note-info">
                                <p>{{ Session::get('message') }}</p>
                            </div>
                        @endif
                        @if ($errors->count() > 0)
                            <div class="note note-danger alert alert-danger">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>- {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" id="latitudActual">
                                    <input type="hidden" id="longitudActual">
                                    <div class="modal fade" id="modal-container-485436" role="dialog"
                                        aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <h5 class="modal-title" id="myModalLabel">
                                                        RUTA
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="mapaRuta" style="height:300px;width:100%"></div>
                                                </div>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">
                                                        Cerrar
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        @yield('content')
                        <span name="administrador" class="hidden"> {!! Auth::user()->evaluarole(['administrador']) !!}</span>
                        <span name="repartidor" class="hidden"> {!! Auth::user()->evaluarole(['repartidor']) !!}</span>
                    </div>
                </div>
            </section>

        </div>
    </div>

    {!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
    <button type="submit">Logout</button>
    {!! Form::close() !!}
    <script src="{{ asset('js/app.js') }}"></script>
    @include('partials.javascripts')
</body>

</html>
