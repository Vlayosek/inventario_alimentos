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
    title: "Producto",
    data: "producto",
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
    title: "Acciones",
    data: "",

  },
];
