<div class="modal fade" id="modal-REGISTRO-SALIDA">
    <div class='modal-dialog'>
        <div class="modal-content " id="modal-contenido">
            <div class="modal-header" style="background:#E9ECEF;">
                SALIDA <span v-show="formSalida.id!='0'" v-text="formSalida.producto"></span>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Producto</label>
                            {!! Form::select('producto', $productos, null, [
                                'id' => 'producto',
                                'class' => 'form-control form-control-sm select2 b-requerido salida',
                                'placeholder' => 'SELECCIONE UNA OPCION',
                            ]) !!}
                            {{-- <input type="text" class="form-control form-control-sm b-requerido producto"
                              v-model="formSalida.descripcion" placeholder="Nombre de Producto" id="descripcion"> --}}
                        </div>
                        <div class="col-md-12">
                            <label>Medida</label>
                            <select v-model='formSalida.medida' class='form-control form-control-sm ' disabled>
                                {{--                                 <option value="0" selected>SELECCIONE UNA OPCION
                              </option> --}}
                                <option v-for="vv in arregloMedidas" :value="vv" v-text="vv" selected>
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Tipo</label>
                            {!! Form::select('tipo', $tipos, null, [
                                'id' => 'tipo',
                                'v-model' => 'formSalida.tipo',
                                'class' => 'form-control form-control-sm ',
                                'placeholder' => 'SELECCIONE UNA OPCION',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>
                        <div class="col-md-12">
                            <label>Cantidad</label>
                            <input type="text" class="form-control form-control-sm numero b-requerido salida "
                                v-model="formSalida.cantidad" id="cantidad" placeholder="Cantidad">
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-primary" disabled v-show="cargando"><img
                        src="{{ url('/spinner.gif') }}">&nbsp;Cargando</button>
                <!-- ACTIVIDAD NUEVA EDITAR -->
                <button class="btn btn-primary" v-show="!cargando " v-on:click='guardarSalida();'>
                    <i class="fa fa-save"></i>&nbsp;Guardar Salida
                </button>

                <button class="btn btn-default btn-sm cerrarmodal " data-dismiss="modal" v-show="!cargando"><b><i
                            class="fa fa-times"></i></b>
                    Cerrar</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
