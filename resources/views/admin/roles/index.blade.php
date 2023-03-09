@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app_')

@section('descripcion_detalle')
    USUARIOS / LISTADO ROLES
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

        /*
                                                                                                                                                                                                                                                                                                                                                                                    Full screen Modal
                                                                                                                                                                                                                                                                                                                                                                                    */
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
    <script src="{{ url('js/modules/admin/menu_rol.js') }}"></script>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-info btn-xs"><i
                            class="fa fa-plus"></i>&nbsp;Agregar Nuevo Rol</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dtop" style="width:100%!important"
                    id="tbRoles">
                    <thead>

                        <th>Roles</th>
                        <th></th>
                        <th>Permisos</th>

                    </thead>
                    <tbody id="tbobyop">

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="modal fade" id="ModalEditRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Roles y Opciones</h4>
                </div>
                <div class="modal-body"> <input type="hidden" id="var" value="0" />

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 form-group">
                                {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                                {!! Form::select('roles', $roles, null, ['class' => 'form-control select2']) !!}

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 form-group">
                                {!! Form::label('permission', 'Permissions', ['class' => 'control-label']) !!}
                                {!! Form::select('permission[]', $permissions, null, [
                                    'class' => 'form-control select2',
                                    'multiple' => 'multiple',
                                ]) !!}

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div style="text-align: center;">
                        {!! Form::button('<b><i class="fa fa-save"></i></b> Agregar Cambios', [
                            'type' => 'button',
                            'class' => 'btn btn-primary',
                            'id' => 'btnGuardar',
                        ]) !!}
                        {!! Form::button('<b><i class="glyphicon glyphicon-remove"></i></b> Cerrar', [
                            'type' => 'button',
                            'class' => 'btn btn-danger',
                            'id' => 'btnCancelar',
                            'data-dismiss' => 'modal',
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/modules/admin/script.js?v=1') }}"></script>
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.roles.mass_destroy') }}';
    </script>
@endsection
