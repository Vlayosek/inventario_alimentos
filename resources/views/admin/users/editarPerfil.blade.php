@extends('layouts.app_')

@section('contentheader_title')
    JuridiCore
@endsection

@section('contentheader_description')
    Sistema Integrado de PublyNext
@endsection

@section('content')
@section('css')
    <link href="{{ url('adminlte3/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('js/modules/uath/perfil.js') }}"></script>
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
        document.getElementById("identificacion").disabled = true;
    </script>
@endsection
<hr />
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Perfil de: <strong>{{ $user->name }}</strong></h4>
            </div>

            <div class="panel-body">
                <div class="panel-content">

                    <div class="panel-body">
                        <div class="panel-body">
                            <div class="col-lg-12" style="margin:5px">
                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        <strong>Identificación:</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Nombres Completos:</strong>
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Apellidos Completos:</strong>
                                    </div>

                                </div>

                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        {!! Form::text('identificacion', $result->identificacion, [
                                            'required' => 'required',
                                            'class' => 'form-control',
                                            'placeholder' => 'Identificación',
                                            'maxlength' => '13',
                                            'id' => 'identificacion',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::text('nombres', $result->nombres, [
                                            'required' => 'required',
                                            'class' => 'form-control',
                                            'placeholder' => 'Nombres',
                                            'id' => 'nombres',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::text('apellidos', $result->apellidos, [
                                            'required' => 'required',
                                            'class' => 'form-control',
                                            'placeholder' => 'Apellidos',
                                            'id' => 'apellidos',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin: 5px">

                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <strong>Género:</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Provincia:</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Ciudad:</strong>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        {!! Form::select('genero', ['0' => 'Genero', 'M' => 'Masculino', 'F' => 'Femenino'], $result->genero, [
                                            'class' => 'form-control select2',
                                            'id' => 'genero',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::select('provincia_id', $provincia, $result->provincia_id, [
                                            'class' => 'form-control select2',
                                            'placeholder' => 'Provincia',
                                            'id' => 'provincia_id',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::select('ciudad_id', $ciudad, $result->ciudad_id, [
                                            'class' => 'form-control select2',
                                            'placeholder' => 'Ciudad',
                                            'id' => 'ciudad_id',
                                        ]) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12" style="margin: 5px">
                                <div class="col-md-4">
                                    <strong>Convencional:</strong>
                                </div>
                                <div class="col-md-4">
                                    <strong>Celular:</strong>
                                </div>
                                <div class="col-md-4">
                                    <strong>Fecha de Ingreso:</strong>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('convencional', $result->telefono, [
                                        'style' => 'resize: none',
                                        'placeholder' => 'Convencional',
                                        'class' => 'form-control',
                                        'id' => 'convencional',
                                        'onKeypress' => 'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;',
                                    ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('celular', $result->celular, [
                                        'style' => 'resize: none',
                                        'placeholder' => 'Celular',
                                        'maxlength' => '10',
                                        'class' => 'form-control',
                                        'id' => 'celular',
                                        'onKeypress' => 'if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;',
                                        'onBlur' => 'verificaCelular()',
                                    ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('ing_empresa', $result->ing_empresa, [
                                        'style' => 'resize: none',
                                        'placeholder' => 'Ingreso a la Empresa:',
                                        'class' => 'form-control pickadate',
                                        'id' => 'ing_empresa',
                                    ]) !!}
                                </div>

                            </div>
                            <div class="col-md-12" style="margin: 5px">

                                <div class="col-md-4">
                                    <strong>Modo:</strong>
                                </div>
                                <div class="col-md-4">
                                    <strong>Cargo:</strong>
                                </div>
                                <div class="col-md-4">
                                    <strong>Lider:</strong>
                                </div>

                                <div class="col-md-4">
                                    {!! Form::select('modo', ['0' => 'Modo', 'A' => 'ACTIVO', 'P' => 'PASIVO'], $result->modo, [
                                        'class' => 'form-control select2',
                                        'id' => 'modo',
                                    ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! Form::select('cargo', $cargo, $result->cargo_id, [
                                        'class' => 'form-control select2',
                                        'placeholder' => 'Cargo',
                                        'id' => 'cargo',
                                    ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! Form::select('lider', $lider, $result->lider_empleado_id, [
                                        'class' => 'form-control select2',
                                        'placeholder' => 'Lider',
                                        'id' => 'lider',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin: 5px">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <strong>Dirección:</strong>
                                    </div>

                                    <div class="col-md-10">
                                        {!! Form::text('direccion', $result->direccion, [
                                            'style' => 'resize: none',
                                            'rows' => '3',
                                            'placeholder' => 'Dirección',
                                            'class' => 'form-control',
                                            'onkeyup' => 'this.value = this.value.toUpperCase()',
                                            'maxlength' => '200',
                                            'id' => 'direccion',
                                        ]) !!}
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-12" style="margin: 5px">

                                <div class="col-md-6">
                                    <strong>Email:</strong>
                                </div>
                                <div class="col-md-6">
                                    <strong>Correo Institucional:</strong>
                                </div>
                                <div class="col-md-6">
                                    {!! Form::email('email', $result->email, [
                                        'style' => 'resize: none',
                                        'rows' => '3',
                                        'placeholder' => 'email',
                                        'class' => 'form-control',
                                        'id' => 'email',
                                    ]) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::email('correo_institucional', $result->correo_institucional, [
                                        'style' => 'resize: none',
                                        'rows' => '3',
                                        'placeholder' => 'Correo Institucional',
                                        'class' => 'form-control',
                                        'id' => 'correo_institucional',
                                    ]) !!}
                                </div>

                            </div>

                            {!! Form::hidden('ciudad_id_h', $result->ciudad_id, ['id' => 'ciudad_id_h']) !!}

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="text-align: center;">
                            {!! Form::button('<b><i class="fa fa-save"></i></b> Guardar Cambios', [
                                'type' => 'button',
                                'class' => 'btn btn-primary',
                                'id' => 'btnGuardar',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
