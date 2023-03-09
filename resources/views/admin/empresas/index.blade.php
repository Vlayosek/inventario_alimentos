@extends('layouts.app_')

@section('contentheader_title')
    FISIOSALUD
@endsection

@section('contentheader_description')
    Sistema Integrado
@endsection

@section('content')
@section('css')
    <link href="{{ url('adminlte3/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte3/plugins/pivot/pivot.css') }}" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('js/modules/admin/empresas.js') }}"></script>
    <script src="{{ url('adminlte3/plugins/pivot/pivot.js') }}"></script>
    <script src="{{ url('adminlte3/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
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
@endsection

<div class="col-lg-2" style="float:right">

    <a href="#" data-hover="tooltip" data-placement="top" class="btn btn-primary" data-target="#Modalagregar"
        data-toggle="modal" id="modal" onclick="limpiar();">Nuevo</a>
</div>
<hr />
<div class="modal fade" id="Modalagregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" style="width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Datos de la Empresa</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="col-lg-12" style="margin:5px">

                        <div class="col-md-12">

                            {!! Form::hidden('id', null, [
                                'required' => 'required',
                                'class' => 'form-control',
                                'placeholder' => 'id',
                                'maxlength' => '13',
                                'id' => 'id',
                            ]) !!}

                            <div class="col-md-6">
                                <strong>Nombres Empresa:</strong>

                                {!! Form::text('nombres', null, [
                                    'required' => 'required',
                                    'class' => 'form-control',
                                    'placeholder' => 'Nombre de la Empresa',
                                    'id' => 'nombres',
                                    'onkeypress' => 'return soloLetras(event)',
                                ]) !!}
                            </div>
                            <div class="col-md-6">
                                <strong>Telféfono:</strong>

                                {!! Form::text('convencional', null, [
                                    'style' => 'resize: none',
                                    'placeholder' => 'Convencional',
                                    'maxlength' => '10',
                                    'class' => 'form-control',
                                    'id' => 'convencional',
                                    'onKeypress' => 'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" style="margin: 5px">

                        <div class="col-md-12">


                            <div class="col-md-6">
                                <strong>Provincia:</strong>

                                {!! Form::select('provincia_id', [], null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => 'PROVINCIA',
                                    'style' => 'width:100%',
                                    'id' => 'provincia_id',
                                ]) !!}

                            </div>
                            <div class="col-md-6">
                                <strong>Ciudad:</strong>

                                {!! Form::select('ciudad_id', [], null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => 'CIUDAD',
                                    'style' => 'width:100%',
                                    'id' => 'ciudad_id',
                                ]) !!}

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12" style="margin: 5px">
                        <div class="col-md-12">

                            <div class="col-md-12">
                                <strong>Direccion:</strong>
                                {!! Form::textarea('direccion', null, [
                                    'style' => 'resize: none',
                                    'rows' => '3',
                                    'placeholder' => 'Dirección',
                                    'class' => 'form-control-t',
                                    'onkeyup' => 'this.value = this.value.toUpperCase()',
                                    'maxlength' => '255',
                                    'id' => 'direccion',
                                ]) !!}
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-12" style="margin: 5px">
                        <div class="col-md-12">

                            <div class="col-md-12">
                                <strong>Descripcion:</strong>
                                {!! Form::textarea('descripcion', null, [
                                    'style' => 'resize: none',
                                    'rows' => '3',
                                    'placeholder' => 'Descripcion de la Empresa ',
                                    'class' => 'form-control-t',
                                    'onkeyup' => 'this.value = this.value.toUpperCase()',
                                    'maxlength' => '255',
                                    'id' => 'descripcion',
                                ]) !!}
                            </div>

                        </div>

                    </div>



                    <input type="hidden" id="ciudad_id_h" value="0">

                </div>
            </div>
            <div class="modal-footer">
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
        <div class="table table-responsive">
            <table class="table table-bordered table-striped" id="dtmenu" style="width:100%!important">
                <thead>

                </thead>
                <tbody id="tbobymenu">

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
