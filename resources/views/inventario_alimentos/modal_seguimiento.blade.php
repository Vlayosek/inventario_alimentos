<div class="modal fade" id="modal-seguimiento">
  <div class='modal-dialog modal-md'>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel" style="font-weight: bold">
          Seguimiento de Solicitud
          <span v-text="': # '+formCrear.id" style="font-size:22px"></span>
        </h5>

      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="history-tl-container">
            <ul class="tl">
              <li :class="(value > 1 || index.indexOf('f|') != -1) ? 'tl-item seleccionado' : 'tl-item'"
                  ng-repeat="retailer_history" v-for="(value, index) in arregloConteoEstados">
                <div class="timestamp"style="font-size:9px;"
                     v-html="(value>1|| index.indexOf('f|')!=-1)?
                                  (arregloEstados[index.replace('t|','').replace('f|','')]+
                                  '<br/>'+
                                  '<strong>'+arregloDatosUsuario[index.replace('t|','').replace('f|','')]+'</strong>'):''">
                </div>

                <div class="item-title 1" style="font-size:10px;"
                     v-show="(
                                      (value>1)&&index.replace('t|','')!=arregloEstadosSolicitudes[index.replace('t|','').replace('f|','')])|| index.indexOf('f|')!=-1
                                  "
                     v-html="'<strong>'+index.replace('t|','').replace('f|','')+'</strong><p>'+arregloEstadosSolicitudes[index.replace('t|','').replace('f|','')]+'</p>'">
                </div>

                <div class="item-title 2" style="font-size:10px;"
                     v-show="index==arregloEstadosSolicitudes[index.replace('t|','')]"
                     v-html="'<strong>'+index+'</strong>'">
                </div>
                <div class="item-title 3" style="font-size:10px;"
                     v-show="(value<2||index.indexOf('f|')==-1)&&!(index.indexOf('f|')!=-1||(value>1)&&index.replace('t|','')!=arregloEstadosSolicitudes[index.replace('t|','').replace('f|','')])"
                     v-html="index.replace('t|','')">
                </div>
              </li>
            </ul>

          </div>
        </div>
      </div>

      <div class="modal-footer justify-content-end">

        <button class="btn btn-default btn-sm cerrarmodal" data-dismiss="modal" v-show="!cargando"><b><i
              class="fa fa-times"></i></b>
          Cerrar</button>
      </div>
    </div>
  </div>
</div>
