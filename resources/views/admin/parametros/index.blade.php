@extends('layouts.app_')

@section('descripcion_detalle')
    PARAMETROS / LISTADO PARAMETROS
@endsection

@section('css')
    <link href="{{ url('adminlte3/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <style>
        label {
            font-size: 12px !important;
        }

        .nav-item {
            font-size: 12px;
        }
    </style>
@endsection

@section('javascript')
    <script src="{{ url('js/modules/admin/parameter.js') }}"></script>
    <script>
        $("#optionid").val('A').change();
        $("#name").on("keyup", function() {
            $(this).val($(this).val().toUpperCase());
        });
    </script>
@endsection

@section('content')
    <div class="card card-info card-outline">
        <div class="card-header">
            <div class="card-title">
                <a class="btn btn-info btn-sm " style="top:20px" data-target="#modal-parametro" role="button"
                    data-toggle="modal" onclick="limpiar()" data-backdrop="static" data-keyboard="false"><i
                        class="fa fa-plus"></i>&nbsp;
                    Nuevo Registro</a>
                @include('admin.parametros.modal')
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive" style="width:100%!important">
                <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important">
                    <thead>
                        <th>Nombre del parametro</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </thead>
                    <tbody id="tbobymenu">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
