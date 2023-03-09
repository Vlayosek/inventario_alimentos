<div class="modal fade" id="modal-permissions" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="exampleModalLabel">Opciones del menu</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <input type="hidden" id="var" value="0" />
                    <div class="form-group">
                        {!! Form::label('optionid', 'Opci&oacute;n Padre:', ['class' => 'text-bold col-lg-12 control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::select('optionid', $father, null, [
                                'class' => 'form-control form-control-sm select2',
                                'style' => 'width:100%',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre Opcion:', ['class' => 'text-bold col-lg-12 control-label']) !!}

                        <div class="col-lg-12">
                            {!! Form::text('name', null, [
                                'required' => 'required',
                                'class' => 'form-control form-control-sm',
                                'placeholder' => 'Nombre de la Opción',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('prefix', 'Prefijo:', ['class' => 'text-bold col-lg-12 control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::number('prefix', null, [
                                'required' => 'required',
                                'class' => 'form-control form-control-sm',
                                'min' => '0',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('url', 'URL de la opci&oacute;n:', ['class' => 'text-bold col-lg-12 control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('url', null, [
                                'class' => 'form-control form-control-sm',
                                'placeholder' => 'prefijo/NombredeOpcion',
                            ]) !!}
                        </div>
                    </div>

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
                        'class' => 'btn btn-danger cerrarmodal',
                        'id' => 'btnCancelar',
                        'data-dismiss' => 'modal',
                    ]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
