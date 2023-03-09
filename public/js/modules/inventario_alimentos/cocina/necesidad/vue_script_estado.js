var app_estados = new Vue({
  el: "#app_estados",
  data() {
    return {
      currentTab_: 1,
      formEstado: {
        pendientes: 0,
        enviados: 0,
        aceptados: 0,
      },
    };
  },
  created: function () {
    this.getKeeps();
  },
  methods: {
    getKeeps: function () {
      var urlKeeps = "consultaEstadosNecesidades";
      let fecha_inicio = $("#fecha_inicio").val();
      let fecha_fin = $("#fecha_fin").val();
      let fill = {
        fecha_inicio: fecha_inicio,
        fecha_fin: fecha_fin,
      };
      axios
        .post(urlKeeps, fill)
        .then((response) => {
          this.formEstado.pendientes = response.data.pendientes;
          this.formEstado.enviados = response.data.enviados;
          this.formEstado.aceptados = response.data.aceptados;
        })
        .catch((error) => {
          app.cargando = false;
        });
    },
  },
});
