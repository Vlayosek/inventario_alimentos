<div class="modal fade" id="modal-REGISTRO-COMPRA">
    <div class='modal-dialog'>
        <div class="modal-content " id="modal-contenido">
            <div class="modal-header" style="background:#E9ECEF;">
                GESTI&Oacute;N DE COMPRA <span v-show="formCompra.id!='0'" v-text="formCompra.producto"></span>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">

                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-primary" disabled v-show="cargando"><img src="{{ url('/spinner.gif') }}">&nbsp;Cargando</button>
                <button class="btn btn-primary" v-show="!cargando " v-on:click='guardarCompra();'>
                    <i class="fa fa-save"></i>&nbsp;Guardar
                </button>
                <button class="btn btn-default btn-sm cerrarmodal " data-dismiss="modal" v-show="!cargando"><b>
                        <i class="fa fa-times"></i></b>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>