var app = new Vue({
  el: "#main",
  data() {
    return {
      currentab: 1,
      formCrear: {
        id: "0",
        persona_id: "",
        fecha_solicitud:"",
        aceptada: false,
        estado_solicitud: {
          descripcion: "BORRADOR",
        },
      },
      formProducto: {
        id: 0,
        necesidad_id: 0,
        producto: "",
        cantidad:"",
        medida: "",
        tipo: "",
        producto_id : ""
      },
      cargando: false,
      consulta: false,
      arregloEstados: [],
      arregloEstadosSolicitudes: [],
      arregloConteoEstados: [],
      arregloDatosUsuario: [],
      enviado: false,
      bandejaJefe: false,
      arregloMedidas: [],
      arregloTipo: [],
    };
  },
  created: function () {},
  methods: {
    limpiarSolicitud: function () {
      this.cargando = false;
      $(".erroresInput").addClass("hidden");
      this.formCrear.id = "0";
      this.formCrear.persona_id = "";
      this.formCrear.fecha_solicitud = "";
      this.formCrear.aceptada = false;
      this.consulta = false;
      $("#medida").val(null).change();
      $("#tipo").val(null).change();
      $("#producto").val(null).change();
      $("#producto option:first-child").attr("disabled", "disabled");
      this.arregloMedidas = [];
    },

    limpiarProducto: function () {
      //this.formActividad.solicitud_id = 0;
      this.formProducto.id = 0;
      // this.formProducto.necesidad_id = 0;
      this.formProducto.producto = "";
      this.formProducto.cantidad = "";
      this.formProducto.medida = "";
      this.formProducto.tipo = "";
      this.formProducto.producto_id = "";
      $(".erroresInput").addClass("hidden");
      $("#medida").val(null).change();
      $("#producto").val(null).change();
      $("#tipo").val(null).change();
      $("#producto option:first-child").attr("disabled", "disabled");
    },

    async generarNecesidad() {
      this.limpiarSolicitud();
      this.formProducto.necesidad_id = 0;
      this.limpiarProducto();
      var urlKeeps = "generarNecesidad";
      var fill = {
        id: 0,
      };
      app.cargando = true;
      iniciar_modal_espera();
      await axios
        .post(urlKeeps, fill)
        .then((response) => {
          if (response.data.status == 200) {
            this.formCrear = response.data.datos;
            this.formCrear.id = response.data.id;
            this.formProducto.necesidad_id = this.formCrear.id;
            this.consulta = false;
            datatableCargarProductos(this.formCrear.id);
            cargarDatatableNecesidades("BORRADOR");

          } else {
            swal("Cancelado!", "Error al consultar...", "error");
            //alertToast("Error al consultar",3500);
          }
          parar_modal_espera();
          app.cargando = false; //desaparece indicador de cargando
        })
        .catch((error) => {
          parar_modal_espera();
          app.cargando = false; //desaparece indicador de cargando
          swal("Cancelado!", "Error al consultar...", "error");
        });
    },

    async traerDatosProducto() {
      var urlKeeps = "traerDatosProducto";
      this.cargando = true;
      let fill = {
        producto: this.formProducto.producto,
      };
      await axios
        .post(urlKeeps, fill)
        .then((response) => {
          this.cargando = false;
          if (response.data.status == 200) {
            this.arregloMedidas = response.data.medida;
            this.arregloTipo = response.data.tipo;

            this.formProducto.medida = this.arregloMedidas[0];
            this.formProducto.tipo = this.arregloTipo[0];
          } else alertToast("Error, recargue la página", 3500);
        })
        .catch((error) => {
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },

    async agregarProducto() {
      var error = buscarErroresInput("producto");

      if (!error) {
        var urlKeeps = "agregarProducto";
        app.cargando = true;
        iniciar_modal_espera();
        await axios
          .post(urlKeeps, this.formProducto)
          .then((response) => {
            if (response.data.status == 200) {
              alertToastSuccess(response.data.message, 3500);
              datatableCargarProductos(this.formCrear.id);
              this.limpiarProducto();
            } else {
              alertToast(response.data.message, 3500);
            }
            parar_modal_espera();
            app.cargando = false; //desaparece indicador de cargando
          })
          .catch((error) => {
            parar_modal_espera();
            app.cargando = false; //desaparece indicador de cargando
            swal("Cancelado!", "Error al consultar...", "error");
          });
      }
    },

    async editarProducto(id) {
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
            this.formProducto = response.data.datos;
            $("#producto").val(this.formProducto.producto).change();
            // $("#medida").val(this.formCompra.medida).change();
          } else alertToast("Error, recargue la página", 3500);
          this.cargando = false;
        })
        .catch((error) => {
          this.cargando = false;
          alertToast("Error, recargue la página", 3500);
        });
    },

    async cancelarEdicion() {
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
            this.formProducto = response.data.datos;
            $("#producto").val(this.formProducto.producto).change();
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

    seguimiento: function (id) {
      var urlKeeps = "seguimiento";
      let fill = {
        id: id,
      };
      axios
        .post(urlKeeps, fill)
        .then((response) => {
          if (response.data.status == 200) {
            this.formCrear.id = id;
            this.arregloEstados = response.data.estados;
            this.arregloEstadosSolicitudes = response.data.datos;
            this.arregloConteoEstados = response.data.conteo_estados;
            this.arregloDatosUsuario = response.data.datos_usuario;
          } else {
            alertToast("Error en cargar las secciones", 3500);
          }
        })
        .catch((error) => {
          this.cargando = false;
        });
    },
  },
});
