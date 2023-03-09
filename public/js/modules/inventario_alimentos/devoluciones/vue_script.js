var app = new Vue({
  el: "#main",
  data() {
    return {
      currentab: 1,
      cargando: false,
      formDevolucion: {
        id: "0",
        producto: "",
        cantidad: 0,
        medida: "",
      },
      arregloMedidas: [],
      arregloTipo: [],
    };
  },
  created: function () {},
  methods: {
    limpiarDevolucion: function () {
      this.formDevolucion.id = "0";
      this.formDevolucion.producto = "";
      this.formDevolucion.cantidad = "";
      this.formDevolucion.medida = "";
      $("#producto").val(null).change();
      this.arregloMedidas = [];
      $(".erroresInput").addClass("hidden");
      $("#producto option:first-child").attr("disabled", "disabled");
    },

    async traerDatosProducto() {
      var urlKeeps = "traerDatosProducto";
      this.cargando = true;
      let fill = {
        producto: this.formDevolucion.producto,
      };
      await axios
        .post(urlKeeps, fill)
        .then((response) => {
          this.cargando = false;
          if (response.data.status == 200) {
            this.arregloMedidas = response.data.medida;
            this.arregloTipo = response.data.tipo;

            this.formDevolucion.medida = this.arregloMedidas[0];
            this.formDevolucion.tipo = this.arregloTipo[0];
          } else alertToast("Error, recargue la página", 3500);
        })
        .catch((error) => {
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },
    async editarDevolucion(id) {
      this.limpiarDevolucion();
      var urlKeeps = "editarDevolucion";
      this.cargando = true;
      let fill = {
        id: id,
      };
      iniciar_modal_espera();
      await axios
        .post(urlKeeps, fill)
        .then((response) => {
          if (response.data.status == 200) {
            console.log(response.data.datos);
            this.formDevolucion = response.data.datos;
            $("#producto").val(this.formDevolucion.producto).change();
            // this.formDevolucion.medida = response.data.datos.medida;
          } else alertToast("Error, recargue la página", 3500);
          this.cargando = false;
          parar_modal_espera();
        })
        .catch((error) => {
          parar_modal_espera();
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },

    async guardarDevolucion() {
      let error = buscarErroresInput("devolucion");
      if (error) return false;

      var urlKeeps = "guardarDevolucion";
      this.cargando = true;

      await axios
        .post(urlKeeps, this.formDevolucion)
        .then((response) => {
          this.cargando = false;
          if (response.data.status == 200) {
            $(".cerrarmodal").trigger("click");
            cargarDatatable();
            alertToastSuccess(response.data.message, 3500);
          } else alertToast(response.data.message, 3500);
        })
        .catch((error) => {
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },

    async eliminarDevolucion(id) {
      swal(
        {
          title: "Estás seguro de eliminar la Devolucion",
          // text: "Escriba el motivo del rechazo:",
          html: true,
          text: "<textarea id='text_rechazo' class='form-control'></textarea>",
          showCancelButton: true,
          closeOnConfirm: false,
          inputPlaceholder: "Escriba el motivo",
        },
        function (inputValue) {
          if (inputValue === false) return false;
          if (inputValue === "") {
            swal.showInputError("Necesita escribir motivo");
            return false;
          }
          var urlKeeps = "eliminarDevolucion";
          var fill = {
            id: id,
            observacion: document.getElementById("text_rechazo").value,
          };
          app.cargando = true;
          axios
            .post(urlKeeps, fill)
            .then((response) => {
              app.cargando = false;
              if (response.data.status == 200) {
                swal("", "Eliminado exitoso", "success");
                cargarDatatable();
              } else swal("Cancelado!", "Error al eliminar...", "error");
            })
            .catch((error) => {
              alertToast("Error, recargue la página", 3500);
            });
        }
      );
    },
  },
});
