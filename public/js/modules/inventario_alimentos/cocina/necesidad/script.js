$(function () {
});
function cargarDatatableNecesidades(tipo = null) {
  app_estados.getKeeps();
  if (tipo != null)
    tipoActual = tipo;
  let fecha_inicio = $("#fecha_inicio").val() == "" || $("#fecha_inicio").val() == null ? "null" : $("#fecha_inicio").val();
  let fecha_fin = $("#fecha_fin").val() == "" || $("#fecha_fin").val() == null ? "null" : $("#fecha_fin").val();
  var error = validarFechasEntradas(fecha_inicio, fecha_fin, 90);
  if (!error) return false;

  let ruta = "/inventario_alimentos/datatableNecesidadesPOSTServerSide/" + fecha_inicio + "/" + fecha_fin + "/" + tipoActual + "";

  formarDatatable("dtNecesidades", ruta, arregloDatosNecesidades, "lBfrtip");
}


function datatableCargarProductos(necesidad_id) {
  if (necesidad_id == 0 || necesidad_id ==null ||  necesidad_id == "0")
    necesidad_id = app.formCrear.id;
  app_estados.getKeeps();
  let ruta = "/inventario_alimentos/getDatatableProductosServerSide/" + necesidad_id + "";
  let arreglo = arregloDatableProductos;
  formarDatatableSimple("dtmenuProductos", ruta, arreglo, "lrtip");
}

function formarDatatable(id, ruta, arreglo, dome = "lBfrtip") {
  $("#" + id + "").dataTable({
    dom: dome,
    destroy: true,
    serverSide: true,
    ajax: ruta,
    //stateSave:true,
    buttons: [
      {
      extend: "excelHtml5",
      text: '<img src="/images/icons/excel.png" width="25px" heigh="25px">Exportar Excel',
      titleAttr: "Excel",
      },
    ],
    responsive: true,
    processing: true,
    lengthMenu: [
      [5, 10, 20],
      [5, 10, 20],
    ],
    lengthChange: true,
    searching: true,
    language: lenguaje,
    order: [
      [0, "desc"]
    ],
    columns: arreglo,
  });
}


function formarDatatableSimple(id, ruta, arreglo, dome = "lrtip") {
  $("#" + id + "").dataTable({
    dom: dome,
    destroy: true,
    serverSide: true,
    ajax: ruta,
    responsive: true,
    processing: true,
    lengthMenu: [
      [5, 10],
      [5, 10],
    ],
    lengthChange: true,
    searching: true,
    language: lenguaje,
    order: [
      [0, "desc"]
    ],
    columns: arreglo,
  });
}
