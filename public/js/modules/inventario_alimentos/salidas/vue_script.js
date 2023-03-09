var app = new Vue({
  el: "#main",
  data() {
    return {
      currentab: 1,
      cargando: false,
      formSalida: {
        id: "0",
        producto: "",
        cantidad: 0,
        medida: "",
        tipo: "",
      },
      arregloMedidas: [],
      arregloTipo: [],
    };
  },
  created: function () {},
  methods: {
    limpiarSalida: function () {
      this.formSalida.id = "0";
      this.formSalida.producto = "";
      this.formSalida.cantidad = "";
      this.formSalida.medida = "";
      this.formSalida.tipo = "";
      $("#medida").val(null).change();
      $("#tipo").val(null).change();
      $("#producto").val(null).change();
      this.arregloMedidas = [];
      $(".erroresInput").addClass("hidden");
      $("#producto option:first-child").attr("disabled", "disabled");
    },

    async traerDatosProducto() {
      var urlKeeps = "traerDatosProducto";
      this.cargando = true;
      let fill = {
        producto: this.formSalida.producto,
      };
      await axios
        .post(urlKeeps, fill)
        .then((response) => {
          this.cargando = false;
          if (response.data.status == 200) {
            console.log(response);
            this.arregloMedidas = response.data.medida;
            this.arregloTipo = response.data.tipo;

            this.formSalida.medida = this.arregloMedidas[0];
            this.formSalida.tipo = this.arregloTipo[0];
          } else alertToast("Error, recargue la página", 3500);
        })
        .catch((error) => {
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },
    async editarSalida(id) {
      this.limpiarSalida();
      var urlKeeps = "editarSalida";
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
            this.formSalida = response.data.datos;

            $("#producto").val(this.formSalida.producto).change();
            // this.formSalida.medida = response.data.datos.medida;
          } else alertToast("Error, recargue la página", 3500);

          this.cargando = false;
          parar_modal_espera();
        })
        .catch((error) => {
          this.cargando = false;
          parar_modal_espera();
          alertToast("Error, recargue la página", 3500);
        });
    },

    async guardarSalida() {
      let error = buscarErroresInput("salida");
      if (error) return false;

      var urlKeeps = "guardarSalida";
      this.cargando = true;
      iniciar_modal_espera();
      await axios
        .post(urlKeeps, this.formSalida)
        .then((response) => {
          console.log(response);
          if (response.data.status == 200) {
            $(".cerrarmodal").trigger("click");
            cargarDatatable();
            alertToastSuccess(response.data.message, 3500);
          } else alertToast(response.data.message, 3500);
          this.cargando = false;
          parar_modal_espera();
        })
        .catch((error) => {
          parar_modal_espera();

          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },

    async eliminarVenta(id) {
      swal(
        {
          title: "Estás seguro de eliminar la Salida",
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
          var urlKeeps = "eliminarVenta";
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
