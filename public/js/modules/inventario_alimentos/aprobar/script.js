$(function () {
  datatableGestion('PENDIENTES');
});

function datatableGestion(tipo = null) {
  app_estados.getKeeps();
  if (tipo != null)
      tipoActual = tipo;
  let fecha_inicio = $("#fecha_inicio").val() == "" || $("#fecha_inicio").val() == null ? "null" : $("#fecha_inicio").val();
  let fecha_fin = $("#fecha_fin").val() == "" || $("#fecha_fin").val() == null ? "null" : $("#fecha_fin").val();
  var error = validarFechasEntradas(fecha_inicio, fecha_fin, 90);
  if (!error) return false;
  let ruta = "/inventario_alimentos/getDatatableGestionSolicitudesServerSide/" + fecha_inicio + "/" + fecha_fin + "/" + tipoActual + "";
  let arreglo = arregloDatableGestionSolicitudes;
  formarDatatable("dtGestionSolicitudes", ruta, arreglo, "lBfrtip");
}
