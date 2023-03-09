<script src="{{ url('adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ url('js/jquery/jqueryuitouch.js') }}"></script>
<script src="{{ url('adminlte/plugins/respond/html5shiv.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/respond/respond.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

<script src="{{ url('adminlte3/plugins/datatables-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ url('adminlte/js/vfs_fonts.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-select/js/select.bootstrap4.min.js') }}"></script>


<script src="{{ url('adminlte3/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-colreorder/js/dataTables.colReorder.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/datatables-colreorder/js/colReorder.bootstrap4.min.js') }}"></script>

<script src="{{ url('adminlte/js/main.js') }}"></script>

<script src="{{ url('adminlte/plugins/notifications/pnotify.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ url('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('adminlte3/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ url('adminlte/js/app.min.js') }}"></script>
<script src="{{ url('adminlte3/dist/js/adminlte.min.js') }}"></script>
<script src="{{ url('adminlte3/dist/js/demo.js') }}"></script>

<script type="text/javascript" src="{{ url('adminlte/plugins/daterange/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ url('adminlte/plugins/daterange/locale.min.js') }}"></script>
<script type="text/javascript" src="{{ url('adminlte3/plugins/daterangepicker/daterangepicker.js') }}"></script>


<script src="{{ url('adminlte3/plugins/dropzone/dropzone.min.js') }}"></script>

<script>
    window._token = '{{ csrf_token() }}';
</script>
<script src="{{ url('js/modules/utils.js') }}"></script>
<script src="{{ url('js/modules/Core.js') }}"></script>



<script src="{{ url('adminlte/plugins/datetimepicker/datetimepicker.js') }}"></script>

<script type="text/javascript">
    $('.timepicker').datetimepicker({
        format: 'LT'
    });

    $("#BuscarFechaConsulta").on("click", function() {
        var v = $("#fechaconsulta").val().replace(' /', '/');
        v = v.replace('/ ', '/');
        v = v.substring(0, 21);
        /* var mes=[1,2,3,4,5,6,7,8,9,10,11,12];
         var dia=[1,2,3,4,5,6,7,8,9,10,11,12,
                  13,14,15,16,17,18,19,20,21,22,23,24,
                  25,26,27,28,29,3,31];*/
        var mes = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        var dia = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12',
            '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24',
            '25', '26', '27', '28', '29', '30', '31'
        ];
        var error = 0
        var r1 = v.substring(4, 5);
        var r2 = v.substring(7, 8);
        var r3 = v.substring(15, 16);
        var r4 = v.substring(18, 19);
        var s = v.substring(10, 11);
        if (r1 != '-' ||
            r2 != '-' ||
            r3 != '-' ||
            r4 != '-' ||
            s != '/') {
            alertToast("El formato no es el adecuado: formato 2019-01-01/2019-12-31", 3500);
            return false;
        }
        //mes 1 y 2
        var m1 = v.substring(5, 7);
        var m2 = v.substring(16, 18);
        if (mes.indexOf(m1) == -1 ||
            mes.indexOf(m2) == -1)
            alertToast("El formato del mes no es el adecuado: [01,02,03,04,05,06,07,08,09,10,11,12]", 3500);

        var d1 = v.substring(8, 10);
        var d2 = v.substring(19, 21);
        if (dia.indexOf(d1) == -1 ||
            dia.indexOf(d2) == -1)
            alertToast("El formato del dia no es el adecuado: [01 hasta 31]", 3500);

    })
    /* INICIO VALIDACION DE CEDULA*/
    function validar(e) {
        var cad = document.getElementById(e.context.id).value.trim();
        var total = 0;
        var longitud = cad.length;
        var longcheck = longitud - 1;
        if (longitud != 10) {
            alertToast("La cedula debe tener 10 dígitos", 3500);
            return false;
        }
        if (cad !== "" && longitud === 10) {
            for (i = 0; i < longcheck; i++) {
                if (i % 2 === 0) {
                    var aux = cad.charAt(i) * 2;
                    if (aux > 9) aux -= 9;
                    total += aux;
                } else {
                    total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
                }
            }

            total = total % 10 ? 10 - total % 10 : 0;
            var cade = cad.charAt(longitud - 1);
            if (cade != total) {
                alertToast("Cedula Inválida", 3500);
            }
        }
    }
    /* FIN VALIDACION DE CEDULA*/
</script>
<script>
    + function(w, d, undefined) {


    }(window, document);

    function guardarDatos() {

    }
</script>
<script type="text/javascript">
    $('.select2').attr('style', 'width : 100%');
    $('.treeview .title').attr('style', 'min-width : 229px');
    $('.treeview-menu').attr('style', 'min-width : 229px');
    $('.modal').removeAttr('tabindex');
    $(".tablinks").on("click", function() {
        var context = $(this).context;
        var id = $(this).val();
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(id).style.display = "block";
        context.className = context.className.search("active") < 0 ? context.className : context.className
            .replace("active", "");
        context.className += " active";
    });
</script>
<script type="text/javascript">
    function soloLetras(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = "8-37-39-46";

        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    }

    function conComas(valor) {
        valor = valor.substring(valor.length - 2, valor.length) > 0 ? valor : valor.substring(0, valor.length - 3);
        var v = valor.length > 3 ? valor.substring(valor.length - 3, valor.length) : 0;
        valor = v != 0 ? valor.substring(0, valor.length - 3) : valor;
        var nums = new Array();
        var simb = ","; //Éste es el separador
        valor = valor.toString();
        valor = valor.replace(/\D/g, ""); //Ésta expresión regular solo permitira ingresar números
        nums = valor.split(""); //Se vacia el valor en un arreglo
        var long = nums.length - 1; // Se saca la longitud del arreglo
        var patron = 3; //Indica cada cuanto se ponen las comas
        var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
        var res = "";

        while (long > prox) {
            nums.splice((long - prox), 0, simb); //Se agrega la coma
            prox += patron; //Se incrementa la posición próxima para colocar la coma
        }

        for (var i = 0.00; i <= nums.length - 1; i++) {
            res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
        }
        v = v != 0 ? v : '';

        var t = res + v;
        var a = t.indexOf(',');
        var b = v.indexOf(',');
        var c = v.indexOf('.');

        if (t.length > 3 && v.length == 3 && (a == -1 || b == -1) && c == -1) {
            var t = res + ',' + v;
        }
        t = t.indexOf('.') != -1 ? t : t + '.00';

        return t;
    }

    function soloNumeros(e) {
        var key = window.Event ? e.which : e.keyCode
        return (key >= 48 && key <= 57)
    }

    function soloNumeros6(e) {
        var key = window.Event ? e.which : e.keyCode
        return (key >= 50 && key <= 54)
    }

    function soloNumeros0_6(e) {
        var key = window.Event ? e.which : e.keyCode
        return (key >= 48 && key <= 54)
    }

    function soloNumeros1_99(e) {
        var key = window.Event ? e.which : e.keyCode
        return (key >= 49 && key <= 54)
    }
    $(".moneda").on({
        "focus": function(event) {
            $(event.target).select();
        },
        "keyup": function(event) {

            $(event.target).val(function(index, value) {
                var vari = value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                return vari;
            });
        }
    });
    $(".numero").on({
        "focus": function(e) {
            $(e.target).select();
        },
        "keypress": function(e) {
            var key = window.Event ? e.which : e.keyCode
            return (key >= 48 && key <= 57)
        }
    });



    function removeElement(array, element) {
        var index = array.indexOf(element);
        if (index >= -1) {
            // modifies array in place
            array.splice(index, 1);
        }
    }

    function agregahora(id) {

        var horario_inicio = $("[name*='hora_inicio[" + id + "]']").val();
        var cant_horas = $("[name*='cant_horas[" + id + "]']").val();

        if (cant_horas == null || cant_horas == '' || cant_horas == 1) {
            cant_horas = 0;
            $("[name*='cant_horas[" + id + "]']").val('').change();

        }

        var fin = (parseInt(horario_inicio.split(":")[0]) + parseInt(cant_horas));
        if (fin < 10) {
            fin = "0" + fin;
        }

        // var horario_fin=$("#horario_fin").val(fin+":00").change();
        // var idhf=$("#idhf").val(fin+":00").change();
        $("[name*='hora_fin[" + id + "]']").val(fin + ":00").change();
        $("[name*='hf[" + id + "]']").val(fin + ":00").change();


    }

    function agregahora2() {
        // var horario_inicio=$("[name*='hora_inicio["+id+"]']" ).val();
        // var cant_horas=$("[name*='cant_horas["+id+"]']" ).val();

        var horario_inicio = $("#horario_inicio").val();
        var cant_horas = $("#cant_horas").val();
        if (cant_horas == null || cant_horas == '' || cant_horas == 1) {
            cant_horas = 0;
            $("#cant_horas").val('').change();
        }
        var fin = (parseInt(horario_inicio.split(":")[0]) + parseInt(cant_horas));
        if (fin < 10) {
            fin = "0" + fin;
        }


        var horario_fin = $("#horario_fin").val(fin + ":00").change();
        var idhf = $("#idhf").val(fin + ":00").change();
        //  $("[name*='hora_fin["+id+"]']" ).val(fin+":00").change();
        //  $("[name*='hf["+id+"]']" ).val(fin+":00").change();
    }

    function PedirConfirmacion(id, dato) {
        swal({
                title: "Estas seguro de realizar esta accion",
                text: "Al confirmar se grabaran los datos exitosamente",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si!",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    switch (dato) {
                        case "save":
                            SaveChanges();
                            break;

                        case "eliminar":
                            var band = 1;
                            Eliminar(id);
                            break;
                        case "activar":
                            var band = 0;
                            DeleteChanges(id, band);
                            break;
                    }
                } else {
                    swal("¡Cancelado!", "No se registraron cambios...", "error");
                }
            });
    }
</script>
<script src="{{ url('adminlte3/plugins/select2/') }}/select21.full.min.js"></script>
<script>
    var dropdowMenu = 0;
    $(".dropdown-menu").hide();
    // Get the modal
    var modal = document.getElementById("myModal");
    var modalPrint = document.getElementById("myModalPrint");
    $(".dropdown-toggle").on("click", function() {
        var dropdownmenuClass = dropdowMenu != 0 ? $(".dropdown-menu").hide() : $(".dropdown-menu").show();
        dropdowMenu = dropdowMenu != 0 ? 0 : 1;
    });
</script>

@yield('javascript')

<script src="{{ url('adminlte3/plugins/select2/js/select2.full.min.js') }}"></script>
