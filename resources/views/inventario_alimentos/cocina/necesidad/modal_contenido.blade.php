<div class="row">
  <div class="col-sm-12" style="text-align:center" v-show="!consulta">
    <label style="color:green">DETALLE DE LOS PRODUCTOS A SOLICITAR</label>
  </div>
  <div class="col-md-3">
    <label>Producto</label>
    {!! Form::select('producto', $productos, null, [
        'id' => 'producto',
        'class' => 'form-control form-control-sm select2 b-requerido producto',
        'placeholder' => 'SELECCIONE UNA OPCION',
    ]) !!}
  </div>
{{--  <div class="col-md-4">--}}
{{--    <label>Fecha de Caducidad</label>--}}
{{--    <input type="date" class="form-control form-control-sm"--}}
{{--           v-model="formProducto.fecha_caducidad" id="fecha_caducidad"--}}
{{--           placeholder="Fecha de Caducidad">--}}
{{--  </div>--}}
  <div class="col-md-3">
    <label>Medida</label>
    <select v-model='formProducto.medida' class='form-control form-control-sm 'disabled>
      <option v-for="(vv,index) in arregloMedidas" :value="vv" v-text="vv">
      </option>
    </select>

  </div>
  <div class="col-md-3">
    <label>Tipo</label>
    <select v-model='formProducto.tipo' class='form-control form-control-sm 'disabled>
      <option v-for="(vv,index) in arregloTipo" :value="vv" v-text="vv">
      </option>
    </select>
  </div>
  <div class="col-sm-3" v-show="!consulta">
    <label>Cantidad</label>
    <div class="input-group">
      <input style="text-align:center" type="text" class="form-control form-control-sm b-requerido numero producto"
             id="numero_horas" v-model="formProducto.cantidad" :disabled="consulta">&nbsp;&nbsp;
      <button class="btn btn-info btn-sm" v-show="!cargando" v-on:click='agregarProducto()'
              :disabled="consulta"><i class="fa fa-plus"></i></button>
      &nbsp;
      <button class="btn btn-default btn-sm" v-show="!cargando" v-on:click='limpiarProducto()'
              :disabled="consulta"><i class="fa fa-ban"></i>Cancelar</button>
    </div>
  </div>
{{--  <div class="col-md-4">--}}
{{--    <label style="background: white">.</label>--}}
{{--    <button class="btn btn-info btn-sm" v-show="!cargando" v-on:click='agregarProducto()'--}}
{{--            :disabled="consulta"><i class="fa fa-plus"></i></button>--}}
{{--  </div>--}}
  <div class="col-sm-12"><br></div>
  <div class="col-sm-12">
    <div class="table" id="tablaConsulta">
      <table class="table table-bordered table-striped" id="dtmenuProductos" style="width:100%!important">
        <thead>
          <th>Reg.</th>
          <th>Producto</th>
          <th>Medida</th>
          <th>Cantidad</th>
          <th>Acciones</th>
        </thead>
        <tbody id="tbobymenu" class="menu-pen">
        </tbody>
      </table>
    </div>
  </div>
</div>
