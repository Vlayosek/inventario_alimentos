@extends('layouts.app')

@section('contentheader_title')
    INVENTARIO DE ALIMENTOS
@endsection

@section('contentheader_description')
    REGISTRO DE NECESIDAD
@endsection

@section('css')
    <link href="{{ url('adminlte/plugins/notifications/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte/style_moderno2.css') }}" rel="stylesheet">
    <style>
      .info-box-t .info-box-icon-t {
        border-radius: .25rem;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        font-size: 12px;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center;
        width: 30px;
      }
    </style>
@endsection
@section('javascript')
    <script src="{{ url('js/modules/inventario_alimentos/cocina/necesidad/global.js?v=4') }}"></script>
    <script src="{{ url('js/modules/inventario_alimentos/cocina/necesidad/script.js?v=4') }}"></script>
    <script>
        $(function () {
          cargarDatatableNecesidades("BORRADOR");
        });

        $("#medida").on("change", function() {
          app.formProducto.medida = $(this).val() != null && $(this).val() != "" ? $(this).val() : 0;
        });
        $("#tipo").on("change", function() {
          app.formProducto.tipo = $(this).val() != null && $(this).val() != "" ? $(this).val() : 0;
        });
        $("#producto").on("change", function() {
          app.formProducto.producto = $(this).val() != null && $(this).val() != "" ? $(this).val() : 0;
          app.traerDatosProducto();
        });

    </script>
@endsection
@section('content')
  <div id="app_estados">
    <div class="card">
      <div class="card-heading" style="padding: 10px;">
        <div class="col-md-12 btnTop">
          <div class="row">
            <div class="col-md-8 btnTop" style="padding-bottom:0px!important;padding-top:0px!important">
              <br>
              <div class="row">
                <div class="col-12 col-sm-9 col-md-2 float-left">
                  <div class="info-box info-box-t">
                                        <span
                                          :class="currentTab_ === 1 ?
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 ' :
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 '"
                                          v-text="formEstado.pendientes" style="color: #ffffff!important;width: 50px;">
                                        </span>
                    <div :class="currentTab_ === 1 ? 'info-box-content ' : 'info-box-content'">
                      <a href="#" class="info-box-text h6 " v-on:click="currentTab_ = 1;"
                         :class="{ link_seleccionado: currentTab_ === 1 }"
                         onclick="cargarDatatableNecesidades('BORRADOR')">
                        BORRADOR</a>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-9 col-md-2 float-left">
                  <div class="info-box info-box-t">
                                        <span
                                          :class="currentTab_ === 2 ?
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 ' :
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 '"
                                          v-text="formEstado.enviados" style="color: #ffffff!important;width: 50px;">
                                        </span>
                    <div :class="currentTab_ === 2 ? 'info-box-content ' : 'info-box-content'">
                      <a href="#" class="info-box-text h6 " v-on:click="currentTab_ = 2;"
                         :class="{ link_seleccionado: currentTab_ === 2 }"
                         onclick="cargarDatatableNecesidades('ENVIADO')">
                        PENDIENTE</a>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-9 col-md-2 float-left">
                  <div class="info-box info-box-t">
                                        <span
                                          :class="currentTab_ === 3 ?
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 ' :
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 '"
                                          v-text="formEstado.aceptados" style="color: #ffffff!important;width: 50px;">
                                        </span>
                    <div :class="currentTab_ === 3 ? 'info-box-content ' : 'info-box-content'">
                      <a href="#" class="info-box-text h6 " v-on:click="currentTab_ = 3;"
                         :class="{ link_seleccionado: currentTab_ === 3 }"
                         onclick="cargarDatatableNecesidades('ACEPTADO')">
                        ACEPTADO
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4" style="padding-bottom:0px!important;padding-top:0px!important" v-show="currentTab_!=1">
              <div class="row">
                <div class="col-md-6">
                  <label>fecha inicio:</label>
                  <div class="input-group">
                    <input type="date" class="form-control" id="fecha_inicio"
                           value="<?php echo date('Y-m-01'); ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <label>fecha fin:</label>
                  <div class="input-group">
                    <input type="date" class="form-control" id="fecha_fin"
                           value="<?php echo date('Y-m-t'); ?>">
                    <span class="input-group-btn">&nbsp;
                                            <button class="btn btn-default" type="button" onclick="cargarDatatableNecesidades()">
                                                <span class="fa fa-search">&nbsp;Buscar</span>
                                            </button>
                                        </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 btnTop"><br>
          <button type="button" class="btn btn-primary btnTop btn-sm" data-toggle="modal"
                  data-target="#modal-REGISTRO-SOLICITUD" onclick="app.generarNecesidad();" data-backdrop="static"
                  data-keyboard="false">
            <i class="fa fa-plus"></i>&nbsp; Generar Necesidad
          </button><br>
        </div>
      </div>
      <div class="card-body">
        <div class="table" id="tablaConsulta">
          <table class="table table-bordered table-striped" id="dtNecesidades" style="width:99%!important">
            <thead>

            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div id="main">
    @include('modules.inventario_alimentos.cocina.necesidad.modal_registro')
    @include('modules.inventario_alimentos.modal_seguimiento')
  </div>
    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/axios.js') }}"></script>
    <script src="{{ url('js/modules/inventario_alimentos/cocina/necesidad/vue_script.js?v=4') }}"></script>
    <script src="{{ url('js/modules/inventario_alimentos/cocina/necesidad/vue_script_estado.js?v=4') }}"></script>
@endsection
