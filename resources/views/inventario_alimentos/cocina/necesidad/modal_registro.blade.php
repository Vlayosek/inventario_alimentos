<div class="modal fade" id="modal-REGISTRO-SOLICITUD">
  <div class='modal-dialog modal-md' style="min-width: 80%!important;">
    <div class="modal-content">
      <div class="modal-header" style="background:#E9ECEF;text-align:center;">
        NECESIDAD <span v-show="formCrear.id!='0'" v-text="formCrear.id"></span>
      </div>

      <div class="modal-body">
        <div class="col-md-12">
          @include('modules.inventario_alimentos.cocina.necesidad.modal_contenido')
        </div>
{{--        <div class="container-fluid">--}}
{{--          <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--              <label>Producto</label>--}}
{{--              {!! Form::select('producto', $productos, null, [--}}
{{--                  'id' => 'producto',--}}
{{--                  'class' => 'form-control form-control-sm select2 b-requerido producto',--}}
{{--                  'placeholder' => 'SELECCIONE UNA OPCION',--}}
{{--              ]) !!}--}}
{{--            </div>--}}
{{--            <div class="col-md-12">--}}
{{--              <label>Fecha de Caducidad</label>--}}
{{--              <input type="date" class="form-control form-control-sm"--}}
{{--                     v-model="formProducto.fecha_caducidad" id="fecha_caducidad"--}}
{{--                     placeholder="Fecha de Caducidad">--}}
{{--            </div>--}}
{{--            <div class="col-md-12">--}}
{{--              <label>Medida</label>--}}
{{--              <select v-model='formProducto.medida' class='form-control form-control-sm 'disabled>--}}
{{--                <option v-for="(vv,index) in arregloMedidas" :value="vv" v-text="vv">--}}
{{--                </option>--}}
{{--              </select>--}}

{{--            </div>--}}
{{--            <div class="col-md-12">--}}
{{--              <label>Tipo</label>--}}
{{--              <select v-model='formProducto.tipo' class='form-control form-control-sm 'disabled>--}}
{{--                <option v-for="(vv,index) in arregloTipo" :value="vv" v-text="vv">--}}
{{--                </option>--}}
{{--              </select>--}}
{{--            </div>--}}
{{--            <div class="col-md-12">--}}
{{--              <label>Cantidad</label>--}}
{{--              <input type="text" class="form-control form-control-sm b-requerido numero producto "--}}
{{--                     v-model="formProducto.cantidad" id="cantidad" placeholder="Cantidad">--}}
{{--            </div>--}}

{{--          </div>--}}
{{--        </div>--}}
      </div>
      <div class="modal-footer justify-content-end">
        <button class="btn btn-primary" disabled v-show="cargando"><img
            src="{{ url('/spinner.gif') }}">&nbsp;Cargando</button>
        <!-- ACTIVIDAD NUEVA EDITAR -->
        <button class="btn btn-primary" v-show="!cargando " v-on:click='guardarNecesidad();'>
          <i class="fa fa-save"></i>&nbsp;Enviar Necesidad
        </button>
        {{--BOTONES PARA ESTADOS--}}
        <button class="btn btn-primary btn-sm hidden" v-show="!cargando && !consulta" v-on:click='guardarRegistro()'><i class="fa fa-save"></i>&nbsp;Guardar Temporal</button>
        <button class="btn btn-primary btn-sm" v-show="!cargando && !consulta" v-on:click='enviarRegistro("ELABORADO")'><i class="fa fa-save"></i>&nbsp;Enviar a aprobar</button>
        <button class="btn btn-default btn-sm cerrarmodal" data-dismiss="modal" v-on:click="limpiarProducto()" id="cerrar_registro_solicitud" v-show="!cargando"><b><i class="fa fa-times"></i></b>
          Cerrar</button>
        {{--FIN BOTONES PARA ESTADOS--}}
      </div>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
