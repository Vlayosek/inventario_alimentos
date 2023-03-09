@extends('layouts.app')

@section('contentheader_title')
    INVENTARIO DE ALIMENTOS
@endsection

@section('contentheader_description')
    SALIDA DE PRODUCTOS
@endsection

@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte3/plugins/chosen/css/chosen.css') }}" rel="stylesheet">

@endsection
@section('javascript')
    <script src="{{ url('js/modules/inventario_alimentos/salidas/global.js?v=2') }}"></script>
    <script src="{{ url('js/modules/inventario_alimentos/salidas/script.js?v=2') }}"></script>
    <script>
        $("#medida").on("change", function() {
            app.formSalida.medida = $(this).val() != null && $(this).val() != "" ? $(this).val() : 0;
        });
        $("#tipo").on("change", function() {
            app.formSalida.tipo = $(this).val() != null && $(this).val() != "" ? $(this).val() : 0;
        });
        $("#producto").on("change", function() {
            app.formSalida.producto = $(this).val() != null && $(this).val() != "" ? $(this).val() : 0;
            app.traerDatosProducto(app.formSalida.producto);
        });
    </script>
@endsection
@section('content')
    <div id="main">
        <div class="card">
            <div class="col-md-12" style="padding:1.25rem">
                <button type="button" class="btn btn-primary btnTop btn-sm escritorio" data-toggle="modal"
                    data-target="#modal-REGISTRO-SALIDA" v-on:click="limpiarSalida();" data-backdrop="static"
                    data-keyboard="false">
                    <i class="fa fa-plus"></i>&nbsp;NUEVA SALIDA
                </button>
            </div>
            <div class="card-body">
                <div class="table" id="tablaConsulta">
                    <table class="table table-bordered table-striped" id="dtVentas" style="width:99%!important">
                        <thead>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('modules.inventario_alimentos.salidas.modal_registro')
    </div>
    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/axios.js') }}"></script>
    <script src="{{ url('js/modules/inventario_alimentos/salidas/vue_script.js?v=2') }}"></script>
@endsection
