let arregloDatosCompras = [
  {
    title: "Id",
    data: "reg_",
  },
  {
    title: "Producto",
    data: "producto",
  },
  {
    title: "Fecha de Caducidad",
    data: "fecha_caducidad",
  },
  {
    title: "Cantidad",
    data: "cantidad",
  },
  {
    title: "Medida",
    data: "medida",
  },
  {
    title: "Tipo",
    data: "tipo",
  },
  {
    title: "Valor de Compra",
    data: "valor_compra",
    render: function (data, type, row) {
      return formatValorMoneda(data);
    },
  },
  {
    title: "Acciones",
    data: "",
    searchable: false,
  },
];

const lenguaje = {
  search: "Buscar",
  lengthMenu: "Mostrar _MENU_",
  zeroRecords: "Lo sentimos, no encontramos lo que estas buscando",
  info: "Motrar página _PAGE_ de _PAGES_ (_TOTAL_)",
  infoEmpty: "Registros no encontrados",
  oPaginate: {
    sFirst: "Primero",
    sLast: "Último",
    sNext: "Siguiente",
    sPrevious: "Anterior",
  },
  infoFiltered: "(Filtrado _TOTAL_  de _MAX_ registros totales)",
};

function formarDatatable(id, ruta, arreglo, dome = "lBfrtip") {
  $("#" + id + "").dataTable({
    dom: dome,
    destroy: true,
    serverSide: true,
    ajax: ruta,
    //stateSave:true,
    buttons: [{
      extend: "excelHtml5",
      text: '<img src="/images/icons/excel.png" width="25px" heigh="25px">Exportar Excel',
      titleAttr: "Excel",
    },
    {
      extend: "pdfHtml5",
      text: '<img src="/images/icons/pdf.png" width="25px" heigh="20px">Exportar pdf',
      titleAttr: "PDF",
      orientation: "landscape",
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

const arregloDatableGestionSolicitudes = [
  {
    title: "Reg",
    data: "id",
    width: "1%",
    name: "necesidades.id",
    searchable: false,
  },
  {
    title: "Fecha Solicitud",
    data: "fecha_solicitud",
    width: "1%",
    name: "necesidades.fecha_solicitud",
    searchable: false,
  },
  {
    title: "Identificación",
    data: "usuario_id_inserta",
    width: "1%",
    name: "necesidades.usuario_id_inserta",
    searchable: false,
  },
  {
    title: "Solicitante",
    data: "apellidos_nombres",
    width: "2%",
    name: "user.nombres",
    searchable: false,
  },
  {
    title: "Acciones",
    data: "",
    width: "1%",
    searchable: false,
  },
];