@extends('layouts.app')

@section('contentheader_title')
    INVENTARIO DE ALIMENTOS
@endsection

@section('contentheader_description')
    REGISTRO DE PRODUCTOS
@endsection

@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte3/plugins/chosen/css/chosen.css') }}" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('js/modules/inventario_alimentos/producto/global.js?v=2') }}"></script>
    <script src="{{ url('js/modules/inventario_alimentos/producto/script.js?v=2') }}"></script>
    <script>
        $("#producto").on("keyup", function() {
            $(this).val($(this).val().toUpperCase());
        });
        $("#medida").on("change", function() {
            app.formProducto.medida = $(this).val() != null && $(this).val() != "" ? $(this).val() : 0;
        });
    </script>
@endsection
@section('content')
    <div id="main">
        <div class="card">
            <div class="col-md-12" style="padding:1.25rem">
                <button type="button" class="btn btn-primary btnTop btn-sm escritorio" data-toggle="modal"
                    data-target="#modal-REGISTRO-PRODUCTO" v-on:click="limpiarProducto();" data-backdrop="static"
                    data-keyboard="false">
                    <i class="fa fa-plus"></i>&nbsp;NUEVO INGRESO PRODUCTO
                </button>
            </div>
            <div class="card-body">
                <div class="table" id="tablaConsulta">
                    <table class="table table-bordered table-striped" id="dtProductos" style="width:99%!important">
                        <thead>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        @include('modules.inventario_alimentos.producto.modal_registro')
    </div>
    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/axios.js') }}"></script>
    <script src="{{ url('js/modules/inventario_alimentos/producto/vue_script.js?v=3') }}"></script>
@endsection
