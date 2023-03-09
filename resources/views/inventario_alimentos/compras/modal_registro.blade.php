<div class="modal fade" id="modal-REGISTRO-COMPRA">
    <div class='modal-dialog'>
        <div class="modal-content " id="modal-contenido">
            <div class="modal-header" style="background:#E9ECEF;">
                COMPRA <span v-show="formCompra.id!='0'" v-text="formCompra.producto"></span>
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
                            {{-- <input type="text" class="hidden b-requerido compra" id="producto"
                                placeholder="Producto" v-model="formCompra.producto"> --}}

                        </div>
                        <div class="col-md-12">
                            <label>Fecha de Caducidad</label>
                            <input type="date" class="form-control form-control-sm"
                                v-model="formCompra.fecha_caducidad" id="fecha_caducidad"
                                placeholder="Fecha de Caducidad">
                        </div>
                        <div class="col-md-12">
                            <label>Medida</label>
                            <select v-model='formCompra.medida' class='form-control form-control-sm 'disabled>
                                <option v-for="(vv,index) in arregloMedidas" :value="vv" v-text="vv">
                                </option>
                            </select>

                        </div>
                        <div class="col-md-12">
                            <label>Tipo</label>
                            <select v-model='formCompra.tipo' class='form-control form-control-sm 'disabled>
                                <option v-for="(vv,index) in arregloTipo" :value="vv" v-text="vv">
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Cantidad</label>
                            <input type="text" class="form-control form-control-sm b-requerido numero compra "
                                v-model="formCompra.cantidad" id="cantidad" placeholder="Cantidad">
                        </div>

                        <div class="col-md-12">
                            <label>Valor de Compra</label>
                            <input type="text" class="form-control form-control-sm b-requerido compra "
                                v-model="formCompra.valor_compra" id="valor_compra"
                                pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="moneda_data"
                                onkeyup="formatValorMonedaId(this)" placeholder="Valor de Compra">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-primary" disabled v-show="cargando"><img
                        src="{{ url('/spinner.gif') }}">&nbsp;Cargando</button>
                <!-- ACTIVIDAD NUEVA EDITAR -->
                <button class="btn btn-primary" v-show="!cargando " v-on:click='guardarCompra();'>
                    <i class="fa fa-save"></i>&nbsp;Guardar Compra
                </button>

                <button class="btn btn-default btn-sm cerrarmodal " data-dismiss="modal" v-show="!cargando"><b><i
                            class="fa fa-times"></i></b>
                    Cerrar</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
