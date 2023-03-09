@extends('layouts.app_')

@section('content')
@section('css')
    <link href="{{ url('adminlte3/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <style>
        .flotante {
            display: scroll;
            position: fixed;
            bottom: 320px;
            right: 0px;
        }
    </style>
@endsection
@section('javascript')
@endsection


<div class="panel panel-default">
    <div class="panel-heading">
        Consulta de datos

    </div>


    <div class="panel-body">
        <div class="col-lg-12">
            <div class="col-md-2">
                <label><strong>Identificacion:</strong></label>
            </div>
            <div class="col-md-2">
                {!! Form::select('identificacion', $objgestores, null, [
                    'class' => 'form-control select2',
                    'style' => 'width:100%',
                    'name' => 'identificacion',
                    'id' => 'identificacion',
                ]) !!}

            </div>
            <div class="col-md-2">

                {!! Form::button('Consultar', ['type' => 'button', 'class' => 'btn btn-primary btn-sm', 'id' => 'btnEnviar']) !!}
            </div>

        </div>
        <table class="table table-bordered table-striped " id="dtmenu" style="width:100%!important">
            <thead>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Fecha de Bloqueo</th>
                <th>Opciones</th>
            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>

    </div>
</div>


@endsection
