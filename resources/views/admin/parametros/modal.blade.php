<div class="modal fade" id="modal-parametro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="exampleModalLabel">Parametros de Sistema</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <input type="hidden" id="var" value="0" />

                    <div class="form-group">
                        {!! Form::label('father', 'Seleccione el parametro báse:', ['class' => 'text-bold col-lg-12 control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::select('father', $father, null, ['class' => 'form-control form-control-sm select2']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre del parametro:', ['class' => 'text-bold col-lg-12 control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('name', null, [
                                'required' => 'required',
                                'class' => 'form-control form-control-sm',
                                'placeholder' => 'Nombre de la Opción',
                                'id' => 'name',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('Estado', 'Estado:', ['class' => 'text-bold col-lg-12 control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::select('optionid', $estado, null, [
                                'placeholder' => 'ESTADO',
                                'class' => 'form-control form-control-sm select2',
                                'id' => 'optionid',
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
