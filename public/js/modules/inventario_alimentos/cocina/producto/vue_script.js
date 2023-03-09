var app = new Vue({
  el: "#main",
  data() {
    return {
      currentab: 1,
      cargando: false,
      formProducto: {
        id: "0",
        producto: "",
        medida: "UNIDAD",
        tipo: "RESIDENCIA",
      },
      consulta: false,
    };
  },
  created: function () {},
  methods: {
    limpiarProducto: function () {
      this.formProducto.id = "0";
      this.formProducto.producto = "";
      this.formProducto.tipo = "RESIDENCIA";
      this.formProducto.medida = "UNIDAD";
      this.consulta = false;
      // $("#medida").val(null).change();
    },

    async editarProducto(id) {
      this.consulta = true;
      this.limpiarProducto();
      var urlKeeps = "editarProducto";
      this.cargando = true;
      let fill = {
        id: id,
      };
      await axios
        .post(urlKeeps, fill)
        .then((response) => {
          if (response.data.status == 200) {
            console.log(response.data.datos);
            this.formProducto = response.data.datos;
            // $("#medida").val(this.formCompra.medida).change();
          } else alertToast("Error, recargue la página", 3500);
          this.cargando = false;
        })
        .catch((error) => {
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },

    async guardarProducto() {
      var urlKeeps = "guardarProducto";
      let error = buscarErroresInput("producto");
      if (error) return false;
      this.cargando = true;

      await axios
        .post(urlKeeps, this.formProducto)
        .then((response) => {
          this.cargando = false;
          if (response.data.status == 200) {
            this.limpiarProducto();
            $(".cerrarmodal").trigger("click");
            cargarDatatableProductos();
            alertToastSuccess(response.data.message, 3500);
          } else alertToast(response.data.message, 3500);
        })
        .catch((error) => {
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },

    async eliminarProducto(id) {
      swal(
        {
          title: "Estás seguro de eliminar el Producto",
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
          var urlKeeps = "eliminarProducto";
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
                cargarDatatableProductos();
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
