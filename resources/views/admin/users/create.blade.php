@extends('layouts.app_')

@section('descripcion_detalle')
    USUARIO / CREAR USUARIO
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

@endsection
@section('content')
    <input type="hidden"id="direccionDocumentos" value="{{ url('storage/USUARIOS/') }}">

    {!! Form::open(['method' => 'PUT', 'route' => ['admin.users.update', 0], 'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-info card-outline">
                <div class="card-header">
                    Creacion de Nuevo Usuario
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::label('nombreCompleto', 'Nombre Completo*', ['class' => 'control-label']) !!}
                                    {!! Form::text('nombreCompleto', null, [
                                        'autocomplete' => 'off',
                                        'class' => 'form-control',
                                        'placeholder' => '',
                                        'required' => '',
                                    ]) !!}
                                    <p class="help-block"></p>
                                    @if ($errors->has('nombreCompleto'))
                                        <p class="help-block">
                                            {{ $errors->first('nombreCompleto') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {!! Form::label('name', 'Usuario*', ['class' => 'control-label']) !!}
                                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                    <p class="help-block"></p>
                                    @if ($errors->has('name'))
                                        <p class="help-block">
                                            {{ $errors->first('name') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="col-12">
                                    {!! Form::label('email', 'Correo de Usuario*', ['class' => 'control-label']) !!}
                                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                    <p class="help-block"></p>
                                    @if ($errors->has('email'))
                                        <p class="help-block">
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    {!! Form::label('password', 'Contraseña', ['class' => 'control-label']) !!}
                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '']) !!}
                                    <p class="help-block"></p>
                                    @if ($errors->has('password'))
                                        <p class="help-block">
                                            {{ $errors->first('password') }}
                                        </p>
                                    @endif
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    {!! Form::label('roles', 'Roles*', ['class' => 'control-label']) !!}
                                    {!! Form::select(
                                        'roles[]',
                                        $roles,
                                        ['ESTANDAR'],
                                        ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => ''],
                                    ) !!}
                                    <p class="help-block"></p>
                                    @if ($errors->has('roles'))
                                        <p class="help-block">
                                            {{ $errors->first('roles') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="row">
                                    <div class="col-xs-12 form-group">
                                        <hr />
                                        {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-lg btn-primary hidden', 'id' => 'savebtn']) !!}
                                        <a href="#" class="btn btn-primary btn-sm"
                                            onclick="$('#savebtn').click()">Guardar</a>
                                        <a href="{{ route('admin.users.index') }}"
                                            class="btn btn-danger btn-sm">Regresar</a>

                                        {!! Form::close() !!}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@stop
