@extends('layouts.app')

@section('contentheader_title')
INVENTARIO DE ALIMENTOS
@endsection

@section('contentheader_description')
GESTION DE NECESIDAD
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
<script src="{{ url('js/modules/inventario_alimentos/compras/global.js?v=3') }}"></script>
<script src="{{ url('js/modules/inventario_alimentos/aprobar/script.js?v=3') }}"></script>
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
                                    <span :class="currentTab_ === 1 ?
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 ' :
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 '" v-text="formEstado.pendientes" style="color: #ffffff!important;width: 50px;">
                                    </span>
                                    <div :class="currentTab_ === 1 ? 'info-box-content ' : 'info-box-content'">
                                        <a href="#" class="info-box-text h6 " v-on:click="currentTab_ = 1;" :class="{ link_seleccionado: currentTab_ === 1 }" onclick="datatableGestion('PENDIENTES')">
                                            PENDIENTES</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-9 col-md-2 float-left">
                                <div class="info-box info-box-t">
                                    <span :class="currentTab_ === 2 ?
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 ' :
                                                'info-box-icon info-box-icon-t bg-primary elevation-1 '" v-text="formEstado.gestionados" style="color: #ffffff!important;width: 50px;">
                                    </span>
                                    <div :class="currentTab_ === 2 ? 'info-box-content ' : 'info-box-content'">
                                        <a href="#" class="info-box-text h6 " v-on:click="currentTab_ = 2;" :class="{ link_seleccionado: currentTab_ === 2 }" onclick="datatableGestion('GESTIONADAS')">
                                            GESTIONADAS</a>
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
                                    <input type="date" class="form-control" id="fecha_inicio" value="<?php echo date('Y-m-01'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>fecha fin:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="fecha_fin" value="<?php echo date('Y-m-t'); ?>">
                                    <span class="input-group-btn">&nbsp;
                                        <button class="btn btn-default" type="button" onclick="datatableGestion()">
                                            <span class="fa fa-search">&nbsp;Buscar</span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table" id="tablaConsulta">
                <table class="table table-bordered table-striped" id="dtGestionSolicitudes" style="width:99%!important">
                    <thead>

                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="app">
    @include('modules.inventario_alimentos.aprobar.modal_gestion')
</div>

<script src="{{ url('js/vue.js') }}"></script>
<script src="{{ url('js/axios.js') }}"></script>
<script src="{{ url('js/modules/inventario_alimentos/aprobar/vue_script.js?v=3') }}"></script>
<script src="{{ url('js/modules/inventario_alimentos/aprobar/vue_script_estados.js?v=3') }}"></script>
@endsection