@extends('layouts.app_')

@section('content')

    @if(session('success'))
        <!-- If password successfully show message -->
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <a class="btn btn-info" style="float:none" href="/"><i class="fa fa-arrow-circle-left"></i>&nbsp;Retornar al Inicio</a>
        </div>
    @else
        {!! Form::open(['method' => 'PATCH', 'route' => ['auth.change_password']]) !!}
        <!-- If no success message in flash session show change password form  -->
        <div class="panel panel-default col-lg-12 col-lg-offset-3" style="width:50%">
            <div class="panel-heading">
                Cambio de Contraseña
            </div>

            <div class="panel-body" >
                <div class="panel-body">


                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('contrasena_anterior', 'contraseña anterior*', ['class' => 'control-label']) !!}
                            {!! Form::password('current_password', ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('current_password'))
                                <p class="help-block">
                                    {{ $errors->first('current_password') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('Nueva Contraseña', 'Nueva Contraseña*', ['class' => 'control-label']) !!}
                            {!! Form::password('new_password', ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('new_password'))
                                <p class="help-block">
                                    {{ $errors->first('new_password') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('nueva_contrasena_confirma', 'Confirmación de Nueva Contraseña*', ['class' => 'control-label']) !!}
                            {!! Form::password('new_password_confirmation', ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('new_password_confirmation'))
                                <p class="help-block">
                                    {{ $errors->first('new_password_confirmation') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
                </div>
            </div>
        </div>


        {!! Form::close() !!}
    @endif
@stop

