<div class="modal fade" id="modal-REGISTRO-DEVOLUCION">
    <div class='modal-dialog'>
        <div class="modal-content " id="modal-contenido">
            <div class="modal-header" style="background:#E9ECEF;">
                DEVOLUCION <span v-show="formDevolucion.id!='0'" v-text="formDevolucion.producto"></span>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Producto</label>
                            {!! Form::select('producto', $productos, null, [
                                'id' => 'producto',
                                'class' => 'form-control form-control-sm select2  b-requerido devolucion',
                                'placeholder' => 'SELECCIONE UNA OPCION',
                            ]) !!}
                        </div>
                        <div class="col-md-12">
                            <label>Medida</label>
                            <select v-model='formDevolucion.medida' class='form-control form-control-sm' disabled>
                                {{--                                 <option value="0" selected>SELECCIONE UNA OPCION
                              </option> --}}
                                <option v-for="vv in arregloMedidas" :value="vv" v-text="vv" selected>
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Cantidad</label>
                            <input type="text" class="form-control form-control-sm b-requerido devolucion "
                                v-model="formDevolucion.cantidad" id="cantidad" placeholder="Cantidad">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-primary" disabled v-show="cargando"><img
                        src="{{ url('/spinner.gif') }}">&nbsp;Cargando</button>
                <!-- ACTIVIDAD NUEVA EDITAR -->
                <button class="btn btn-primary" v-show="!cargando " v-on:click='guardarDevolucion();'>
                    <i class="fa fa-save"></i>&nbsp;Guardar Devolucion
                </button>

                <button class="btn btn-default btn-sm cerrarmodal " data-dismiss="modal" v-show="!cargando"><b><i
                            class="fa fa-times"></i></b>
                    Cerrar</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
