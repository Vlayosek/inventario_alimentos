var app_estados = new Vue({
  el: "#app_estados",
  data() {
    return {
      currentTab_: 1,
      formEstado: {
        pendientes: 0,
        gestionados: 0,
      },
      cargando:false,
    };
  },
  created: function () {
    this.getKeeps();
  },
  methods: {
    getKeeps: function () {
      var urlKeeps = "filtroEstadosGestion";
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
          this.formEstado.gestionados = response.data.gestionados;
        })
        .catch((error) => {
          this.cargando = false;
        });
    },
  },
});
