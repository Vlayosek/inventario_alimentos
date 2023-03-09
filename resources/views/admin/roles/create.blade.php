@extends('layouts.app_')


@section('descripcion_detalle')
    ROLES / CREAR ROL
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
    <script src="{{ url('js/modules/admin/menu_rol.js') }}"></script>
    <script>
        $("#name").on("keyup", function() {
            $(this).val($(this).val().toUpperCase());
        });
    </script>
@endsection

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['admin.roles.store']]) !!}
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-info card-outline">
                <div class="card-header">
                    Creacion de Nuevo Rol
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if ($errors->has('name'))
                                <p class="help-block">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! Form::label('permission', 'Permissions', ['class' => 'control-label']) !!}
                            {!! Form::select('permission[]', $permissions, old('permission'), [
                                'class' => 'form-control select2',
                                'multiple' => 'multiple',
                                'required' => 'required',
                            ]) !!}
                            <p class="help-block"></p>
                            @if ($errors->has('permission'))
                                <p class="help-block">
                                    {{ $errors->first('permission') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <hr />
                        <div class="col-lg-12">
                            {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-lg btn-primary hidden', 'id' => 'savebtn']) !!}
                            <a href="#" class="btn btn-primary" onclick="$('#savebtn').click()">Guardar</a>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-danger">Regresar</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
