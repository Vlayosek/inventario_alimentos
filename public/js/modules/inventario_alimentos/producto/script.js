$(function () {
  cargarDatatableProductos();
});

function cargarDatatableProductos() {
  let fill = {};
  creardatatable(
    "dtProductos",
    arregloDatosProductos,
    "/inventario_alimentos/datatableProductosPOSTServerSide",
    fill
  );
}

function creardatatable(id, datos, ruta, parametro = null) {
  $("#" + id + "").DataTable({
    dom: "lfrtip",
    processing: true,
    serverSide: true,
    destroy: true,
    responsive: true,
    ajax: {
      url: ruta,
      type: "POST",
      data: parametro,
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    },
    columns: datos,
  });
}
