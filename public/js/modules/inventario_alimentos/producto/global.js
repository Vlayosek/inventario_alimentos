let arregloDatosProductos = [
  {
    title: "Registro",
    data: "fecha_inserta",
    visible:false
  },
  {
    title: "Id",
    data: "reg_",
  },
  {
    title: "Descripcion",
    data: "producto",
  },
  {
    title: "Tipo",
    data: "tipo",
  },
  {
    title: "Medida",
    data: "medida",
  },
  {
    title: "Stock",
    data: "stock",
    render: function (data, type, row) {
      return row.stock == null ? 0 : row.stock;
    },
  },
  {
    title: "Compras",
    data: "compras",
    render: function (data, type, row) {
      return row.compras == null ? 0 : row.compras;
    },
  },
  {
    title: "Salida Total",
    data: "salida_total",

  },
  {
    title: "Salida",
    data: "ventas",
    render: function (data, type, row) {
      return row.ventas == null ? 0 : row.ventas;
    },
  },
  {
    title: "Devoluciones",
    data: "devoluciones",
    render: function (data, type, row) {
      return row.devoluciones == null ? 0 : row.devoluciones;
    },
  },
  {
    title: "Acciones",
    data: "",

  },
];
