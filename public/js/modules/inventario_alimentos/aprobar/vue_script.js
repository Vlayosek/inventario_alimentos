var app = new Vue({
  el: "#app",
  data() {
    return {
      cargando: false,
      formCompra: {
        id: "0",
        producto: "",
        fecha_caducidad: "",
        cantidad: 0,
        medida: "",
        tipo: "",
        valor_compra: "",
      },
    };
  },
  created: function () {},
  methods: {
    limpiarCompra: function () {
      this.formCompra.id = "0";
      this.formCompra.producto = "";
      this.formCompra.fecha_caducidad = "";
      this.formCompra.cantidad = "";
      this.formCompra.medida = "";
      this.formCompra.tipo = "";
      this.formCompra.valor_compra = "";
      this.formCompra.medida = "";
      $(".erroresInput").addClass("hidden");
    },
  },
});
