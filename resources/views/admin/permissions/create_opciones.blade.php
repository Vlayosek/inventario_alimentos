@extends('layouts.app_')

@section('descripcion_detalle')
    MENU / LISTADO MEN&Uacute;
@endsection

@section('css')
    <link href="{{ url('adminlte3/plugins/sweetalert2/sweetalert2.css') }}" rel="stylesheet">
    <style>
        label {
            font-size: 12px !important;
        }

        .nav-item {
            font-size: 12px;
        }

        .menu-tab {
            background: #3a4e7b;
            padding: 0px;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #000;
            background-color: #fff;
        }

        .nav-pills .nav-link {
            border-radius: 0px;
        }

        .nav-pills .nav-link {
            color: #ffffff;
        }

        .green {
            color: green;
        }

        .red {
            color: red;
        }

        li {
            list-style: none;
        }

        .fullscreen-modal .modal-dialog {
            margin: 0;
            margin-right: auto;
            margin-left: auto;
            width: 100%;
        }

        @media (min-width: 768px) {
            .fullscreen-modal .modal-dialog {
                width: 750px;
            }
        }

        @media (min-width: 992px) {
            .fullscreen-modal .modal-dialog {
                width: 970px;
            }
        }

        @media (min-width: 1200px) {
            .fullscreen-modal .modal-dialog {
                width: 1170px;
            }
        }
    </style>
@endsection

@section('javascript')
    <script src="{{ url('js/modules/admin/admin.js') }}"></script>
    <script>
        $("#name").on("keyup", function() {
            $(this).val($(this).val().toUpperCase());
        });
    </script>
@endsection

@section('content')
    <div class="card card-info card-outline">
        <div class="card-header">
            <div class="card-title">
                <a class="btn btn-info btn-sm " style="top:20px" href="#modal-permissions" role="button" data-toggle="modal"
                    onclick="limpiar()" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i>&nbsp;
                    Nuevo Registro</a>
                @include('admin.permissions.modal')

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="width:100%!important">
                <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important">
                    <thead>
                        <th>Nombre de la Opción</th>
                        <th>Url</th>
                        <th>Opciones</th>
                    </thead>
                    <tbody id="tbobymenu">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
