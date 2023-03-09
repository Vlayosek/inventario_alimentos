var app = new Vue({
  el: "#main",
  data() {
    return {
      currentab: 1,
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
      arregloMedidas: [],
      arregloTipo: [],
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
        producto: this.formCompra.producto,
      };
      await axios
        .post(urlKeeps, fill)
        .then((response) => {
          this.cargando = false;
          if (response.data.status == 200) {
            console.log(response);
            this.arregloMedidas = response.data.medida;
            this.arregloTipo = response.data.tipo;

            this.formCompra.medida = this.arregloMedidas[0];
            this.formCompra.tipo = this.arregloTipo[0];
          } else alertToast("Error, recargue la página", 3500);
        })
        .catch((error) => {
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },
    async editarCompra(id) {
      this.limpiarCompra();
      var urlKeeps = "editarCompra";
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
            this.formCompra = response.data.datos;
            /* $("#medida").val(this.formCompra.medida).change();
            $("#tipo").val(this.formCompra.tipo).change(); */
            $("#producto").val(this.formCompra.producto).change();
            // this.formCompra.medida = response.data.datos.medida;
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

    async guardarCompra() {
      let error = buscarErroresInput("compra");
      if (error) return false;

      var urlKeeps = "guardarCompra";
      this.cargando = true;

      this.formCompra.valor_compra = limpiarDataMoney(
        this.formCompra.valor_compra
      );

      await axios
        .post(urlKeeps, this.formCompra)
        .then((response) => {
          this.cargando = false;
          if (response.data.status == 200) {
            $(".cerrarmodal").trigger("click");
            cargarDatatable();
            alertToastSuccess(response.data.message, 3500);
          } else alertToast("Error, recargue la página", 3500);
        })
        .catch((error) => {
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },

    async eliminarCompra(id, producto) {
      swal(
        {
          title: "Estás seguro de eliminar la Compra",
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
          var urlKeeps = "eliminarCompra";
          var fill = {
            id: id,
            producto: producto,
            observacion: document.getElementById("text_rechazo").value,
          };
          app.cargando = true;
          axios
            .post(urlKeeps, fill)
            .then((response) => {
              console.log(response);
              app.cargando = false;
              if (response.data.status == 200) {
                swal("", response.data.message, "success");
                cargarDatatable();
              } else swal("Cancelado!", response.data.message, "error");
            })
            .catch((error) => {
              alertToast("Error, recargue la página", 3500);
            });
        }
      );
    },
  },
});
