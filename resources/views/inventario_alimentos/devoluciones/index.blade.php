@extends('layouts.app')

@section('contentheader_title')
    INVENTARIO DE ALIMENTOS
@endsection

@section('contentheader_description')
    DEVOLUCIONES DE PRODUCTOS
@endsection

@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte3/plugins/chosen/css/chosen.css') }}" rel="stylesheet">

@endsection
@section('javascript')
    <script src="{{ url('js/modules/inventario_alimentos/devoluciones/global.js?v=2') }}"></script>
    <script src="{{ url('js/modules/inventario_alimentos/devoluciones/script.js?v=2') }}"></script>
    <script>
        $("#producto").on("change", function() {
            app.formDevolucion.producto = $(this).val() != null && $(this).val() != "" ? $(this).val() : 0;
            app.traerDatosProducto(app.formDevolucion.producto);
        });
        $("#medida").on("change", function() {
            app.formDevolucion.medida = $(this).val() != null && $(this).val() != "" ? $(this).val() : 0;
        });
    </script>
@endsection
@section('content')
    <div id="main">
        <div class="card">
            <div class="col-md-12" style="padding:1.25rem">
                <button type="button" class="btn btn-primary btnTop btn-sm escritorio" data-toggle="modal"
                    data-target="#modal-REGISTRO-DEVOLUCION" v-on:click="limpiarDevolucion();" data-backdrop="static"
                    data-keyboard="false">
                    <i class="fa fa-plus"></i>&nbsp;NUEVA DEVOLUCION
                </button>
            </div>
            <div class="card-body">
                <div class="table" id="tablaConsulta">
                    <table class="table table-bordered table-striped" id="dtDevoluciones" style="width:99%!important">
                        <thead>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('modules.inventario_alimentos.devoluciones.modal_registro')
    </div>
    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/axios.js') }}"></script>
    <script src="{{ url('js/modules/inventario_alimentos/devoluciones/vue_script.js?v=3') }}"></script>
@endsection
