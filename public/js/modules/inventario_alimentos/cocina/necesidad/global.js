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


let arregloDatosNecesidades = [
  {
    title: "Id",
    data: "reg",
  },
  {
    title: "Fecha Solicitud",
    data: "fecha_solicitud",
  },
  {
    title: "Aceptada",
    data: "aceptada",
    render: function (data, type, row) {
      return row.aceptada == false ?  "<span class='badge bg-warning'>NO</span>" : "<span class='badge bg-primary'>SI</span>";
    },
  },
  {
    title: "Estado",
    data: "estado",
    render: function (data, type, row) {
      return '<span class="badge bg-primary">' + row.estado + "</span>";
    },
  },
  {
    title: "Acciones",
    data: "",

  },
];


const arregloDatableProductos = [
  {
  data: "id",
  width: "1%",
  //searchable: true,
  },
  {
    data: "producto",
    width: "1%",
    //searchable: true,
  },
  {
    data: "medida",
    width: "1%",
    //searchable: true,
  },
  {
    data: "cantidad",
    width: "1%",
    //searchable: true,
  },
  {
    data: "",
    width: "1%",
    //searchable: true,
  },
];
