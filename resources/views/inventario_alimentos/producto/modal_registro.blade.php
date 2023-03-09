{{-- MODAL DE REGISTRO DE PRODUCTO --}}
<div class="modal fade" id="modal-REGISTRO-PRODUCTO">
    <div class='modal-dialog'>
        <div class="modal-content " id="modal-contenido">
            <div class="modal-header" style="background:#E9ECEF;">
                PRODUCTO <span v-show="formProducto.id!='0'" v-text="formProducto.producto"></span>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Descripcion</label>
                            <input type="text" class="form-control form-control-sm b-requerido producto"
                                v-model="formProducto.producto" placeholder="Nombre de Producto" id="producto">
                        </div>
                        <div class="col-md-12">
                            <label>Medida</label>
                            {!! Form::select('medida', $medidas, null, [
                                'id' => 'medida',
                                'class' => 'form-control form-control-sm b-requerido producto',
                                'v-model' => 'formProducto.medida',
                                'placeholder' => 'SELECCIONE UNA OPCION',
                                // ':disabled' => 'consulta === true',
                            ]) !!}
                        </div>
                        <div class="col-md-12">
                            <label>Tipo</label>
                            {!! Form::select('tipo', $tipos, null, [
                                'id' => 'tipo',
                                'class' => 'form-control form-control-sm b-requerido producto',
                                'v-model' => 'formProducto.tipo',
                                'placeholder' => 'SELECCIONE UNA OPCION',
                                // ':disabled' => 'consulta === true',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-primary" disabled v-show="cargando"><img
                        src="{{ url('/spinner.gif') }}">&nbsp;Cargando</button>
                <!-- ACTIVIDAD NUEVA EDITAR -->
                <button class="btn btn-primary" v-show="!cargando " v-on:click='guardarProducto();'>
                    <i class="fa fa-save"></i>&nbsp;Guardar Producto
                </button>

                <button class="btn btn-default btn-sm cerrarmodal " data-dismiss="modal" v-show="!cargando"><b><i
                            class="fa fa-times"></i></b>
                    Cerrar</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
