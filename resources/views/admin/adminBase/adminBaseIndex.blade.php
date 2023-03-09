@extends('layouts.app_')


@section('content')
@section('css')
    <link href="{{ url('adminlte3/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte3/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
    {!! Html::style('adminlte3/plugins/fileinput/fileinput.min.css') !!}
@endsection
@section('javascript')
    <script src="{{ url('js/modules/admin/adminBase.js') }}"></script>
    <script src="{{ url('adminlte3/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    {!! Html::script('adminlte3/plugins/fileinput/fileinput.min.js') !!}

    <script>
        $('.pickadate').datepicker({
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd',
            selectYears: true,
            editable: true,
            autoclose: true,
            orientation: 'top'
        });
    </script>
    <script>
        $('.file-input-new').fileinput({
            showUpload: true,
            showPreview: true,
            browseLabel: "Buscar",
            removeLabel: "Quitar",
            allowedFileExtensions: ['txt'],
            maxFileCount: 1
        }).on('fileerror', function(event, data) {
            alertToast("Solo se admiten cargar 1 archivo a la vez", 3500);
        });
    </script>
@endsection
<div class="col-lg-2" style="float:right">

    <a href="#" data-hover="tooltip" data-placement="top" class="btn btn-primary" data-target="#Modalagregar"
        data-toggle="modal" id="modal" onclick="limpiar();">Nuevo</a>
</div>
<hr />

<div class="modal fade" id="Modalagregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Agregar Base</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-body">
                    {!! Form::file('archivos[]', [
                        'id' => 'ARCHIVOS',
                        'label' => 'SELECCIONE LOS ARCHIVOS NECESARIOS: ',
                        'required' => true,
                        'multiple' => 'multiple',
                        'test' => 'ALE',
                        'class' => 'file-input-new',
                    ]) !!}
                    <div class="col-lg-5">
                        <label>Con cabecera</label>
                        <input type="checkbox" value="0" name="cabecera" id="cabecera">

                        <input type="hidden" value="0" name="cabecerac" id="cabecerac">
                    </div>
                </div>
                <div style="text-align: center;">
                    {!! Form::button('<b><i class="fa fa-save"></i></b> Guardar Cambios', [
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

<div class="panel panel-default">
    <div class="panel-heading">
        Consulta de datos

    </div>

    <div class="panel-body">
        <div class="col-lg-12" id="destado">
            <div class="col-lg-2" style="float:left">
                <label>Busqueda por:</label>

                {!! Form::select('criterio', [], 0, [
                    'class' => 'form-control select2',
                    'style' => 'width:100%',
                    'id' => 'criterio',
                ]) !!}
            </div>
            <div class="col-lg-2" style="float:left">
                <label>Cantidad:</label>
                {!! Form::number('parametro', null, [
                    'class' => 'form-control',
                    'min' => '0',
                    'step' => '100',
                    'id' => 'parametro',
                ]) !!}
            </div>
            <div class="col-lg-2" style="float:left">

                <label>Fecha/Creación-Inicio:</label>

                {!! Form::text('fecha_inicio', null, [
                    'class' => 'form-control pickadate',
                    'id' => 'fechai',
                    'placeholder' => 'Seleccione fecha ',
                    '',
                ]) !!}
            </div>
            <div class="col-lg-2" style="float:left">
                <label>Fecha/Creación-Final:</label>

                {!! Form::text('fecha_final', null, [
                    'class' => 'form-control pickadate',
                    'id' => 'fechaf',
                    'placeholder' => 'Seleccione fecha ',
                    '',
                ]) !!}
            </div>
            <div class="col-lg-2" style="float:left">
                <br>
                {!! Form::button('Vista Datos', ['type' => 'button', 'class' => 'btn btn-primary', 'id' => 'btnEstado']) !!}
            </div>

        </div>
        <table class="table table-bordered table-striped " id="dtmenu" style="display:none"
            style="width:100%!important">
            <thead>

                <th>Identificacion</th>
                <th>Telefono</th>
                <th>Nombres</th>
                <th>Direccion</th>

            </thead>
            <tbody id="tbobymenu">

            </tbody>
        </table>
    </div>
</div>

@endsection
