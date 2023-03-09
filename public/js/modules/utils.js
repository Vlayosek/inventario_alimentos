/**
 * Created by blacksato on 21/5/2017.
 */
function fullScreen() {
    (document.fullScreenElement && null !== document.fullScreenElement) ||
    (!document.mozFullScreen && !document.webkitIsFullScreen)
        ? document.documentElement.requestFullScreen
            ? document.documentElement.requestFullScreen()
            : document.documentElement.mozRequestFullScreen
            ? document.documentElement.mozRequestFullScreen()
            : document.documentElement.webkitRequestFullScreen &&
              document.documentElement.webkitRequestFullScreen(
                  Element.ALLOW_KEYBOARD_INPUT
              )
        : document.cancelFullScreen
        ? document.cancelFullScreen()
        : document.mozCancelFullScreen
        ? document.mozCancelFullScreen()
        : document.webkitCancelFullScreen && document.webkitCancelFullScreen();
}
function checkSession() {
    $.ajax({
        type: "GET",
        url: "/checksession",
        headers: { "X-CSRF-TOKEN": $("#token").val() },
        cache: false,
        data: getHour(),
        success: function (res) {
            if (!res.login) {
                window.location.href = "/";
            }
        },
    });
}
function getHour() {
    var time = new Date();
    var hour = time.getHours();
    var minute = time.getMinutes();
    var seconds = time.getSeconds();

    var str_hora = new String(hour);
    if (str_hora.length == 1) {
        hour = "0" + hour;
    }
    var str_minuto = new String(minute);
    if (str_minuto.length == 1) {
        minute = "0" + minute;
    }
    var str_segundo = new String(seconds);
    if (str_segundo.length == 1) {
        seconds = "0" + seconds;
    }

    return hour + ":" + minute + ":" + seconds;
}
function timeNow() {
    setTimeout("timeNow()", 1000);

    $("#lbl_time").html("<b>Hora: </b>" + getHour());
}

/*
 Funcion que me permite realizar dependencias entre combos
 */
function selectDependent(father, children, check, multiple) {
    valueFather = $(father).val() == "" ? 0 : $(father).val();

    if (valueFather != "0") {
        var objApiRest = new AJAXRest(
            "/catalog/dataBySelectSingle/" + valueFather,
            {},
            "POST"
        );
        objApiRest.extractDataAjax(function (_resultContent, status) {
            if (status == 200) {
                if (!multiple) {
                    $(children).html('<option value="0">-Seleccione-</option>');
                } else {
                    $(children).html("");
                }

                if (_resultContent.data.length == 0) {
                    alertToast("La solicitud no obtuvo resultados", 3500);
                } else {
                    $.each(_resultContent.data, function (key, value) {
                        var checked = check == key ? "selected" : "";
                        $(children).append(
                            "<option value=" +
                                key +
                                " " +
                                checked +
                                ">" +
                                value +
                                "</option>"
                        );
                    });
                }
                if (!multiple) $(children).val(check).trigger("change");
            } else {
                alertToast(_resultContent.message, 3500);
            }
        });
    } else {
        if (!multiple) {
            $(children).html('<option value="0">-Seleccione-</option>');
        } else {
            $(children).html("");
        }
    }
}

function verifyKeyPressPattern(e, patron, object, width) {
    var tecla = document.all ? e.keyCode : e.which; // 2
    if (tecla == 8 || tecla == 0) {
        $(object).removeAttr("style");
        return true; // 3
    }
    var te = String.fromCharCode(tecla); // 5
    var result = patron.test(te);
    if (!result) {
        $(object).attr("style", "background-color: #F8E0E6;" + width);
    } else {
        $(object).attr("style", "background-color: #fff;" + width);
    }
    return result;
}
function putAttrInput(elements, flag) {
    if (!flag) {
        $.each(elements, function (index, value) {
            $("#" + value).removeAttr("disabled");
        });
    } else {
        $.each(elements, function (index, value) {
            $("#" + value).attr("disabled", "disabled");
        });
    }
}
function showHideInput(elements, flag) {
    if (!flag) {
        $.each(elements, function (index, value) {
            $("#" + value)
                .parent()
                .parent()
                .show();
        });
    } else {
        $.each(elements, function (index, value) {
            $("#" + value)
                .parent()
                .parent()
                .hide();
        });
    }
}
function clearInputName(elements, pvalue) {
    $.each(elements, function (index, value) {
        $("input[name=" + value + "]").val(pvalue);
    });
}
function clearSelectName(elements, pvalue) {
    $.each(elements, function (index, value) {
        $("select[name=" + value + "]").val(pvalue);
    });
}
function clearInput(elements, pvalue) {
    $.each(elements, function (index, value) {
        $("#" + value).val(pvalue);
    });
}
function clearInputSelect(elements, pvalue) {
    $.each(elements, function (index, value) {
        $("#" + value)
            .val(pvalue)
            .trigger("change");
    });
}
function addOptionSelect(elements, pvalue) {
    $.each(elements, function (index, value) {
        $("#" + value).prepend(pvalue);
    });
}
function fileInputBasicCustom(_maxFileSizeByte, _maxFileSizeMB, _extensions) {
    $(".file-input")
        .fileinput({
            maxFileSize: _maxFileSizeByte,
            showPreview: false,
            showUpload: false,
            browseLabel: "Buscar",

            removeLabel: "",
            language: "en",
            browseIcon: '<i class="icon-file-plus"></i>',
            browseClass: "btn btn-primary  btn-xs",
            removeClass: "btn bg-pink-400 btn-xs",
            previewFileIconClass: "file-icon",
            removeTitle: "Quitar archivo seleccionado",
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
            },
            initialCaption: "",
            allowedFileExtensions: _extensions,
        })
        .on("fileerror", function (event, data) {
            alertToast(
                "Solo se admiten extensiones pdf, con peso m\u00E1ximo de " +
                    _maxFileSizeMB +
                    " MB",
                4000
            );
            $(data).fileinput("clear");
        });
}

function referencePathOriginal(_ref) {
    var namefile = $(_ref).attr("data-namefile");
    var pathdoc = $(_ref).attr("data-path");
    var module = $(_ref).attr("data-module");
    var divurlmodal = $(_ref).attr("data-div");
    $.ajax({
        url: "/global/get-file-ftp",
        type: "post",
        headers: { "X-CSRF-TOKEN": $("input[name='_token']").val() },
        data: { namefile: namefile, pathdoc: pathdoc, module: module },
        dataType: "json",
        success: function (result) {
            if (result.link.trim() != "none") {
                viewModalURL("/" + result.link);
                $("#" + divurlmodal).html(
                    "<span onclick='viewModalURL(\"/" +
                        result.link +
                        "\")' class='label bg-teal'  style='cursor:pointer'>" +
                        namefile +
                        "</span>"
                );
            } else {
                alertToast("NO SE PUEDE OBTENER EL ARCHIVO SOLICITADO", 3500);
            }
        },
        error: function (e) {
            alertToast("NO SE PUEDE OBTENER EL ARCHIVO SOLICITADO", 3500);
        },
        fail: function (result) {
            alertToast("NO SE PUEDE OBTENER EL ARCHIVO SOLICITADO", 3500);
        },
    });
}
function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || "";
    sliceSize = sliceSize || 512;

    var byteCharacters = atob(b64Data);
    var byteArrays = [];

    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    var blob = new Blob(byteArrays, { type: contentType });
    return blob;
}
function putAttrInputCustom(elements, flag, attributes, valueAttr) {
    if (!flag) {
        $.each(elements, function (index, value) {
            $("#" + value).removeAttr(attributes);
        });
    } else {
        $.each(elements, function (index, value) {
            $("#" + value).attr(attributes, valueAttr);
        });
    }
}
function putAttrArray(elements, attributes) {
    $.each(elements, function (index, value) {
        $("#" + value).attr(attributes);
    });
}
var AJAXRestFilePOST = function (path, parameters) {
    this._path = path;
    this._parameters = parameters;
    this._resultContent = {};
    this.extractDataAjaxFile = function (callback) {
        $.ajax({
            url: this._path,
            type: "POST",
            dataType: "json",
            data: this._parameters,
            enctype: "multipart/form-data",
            cache: false,
            contentType: false,
            processData: false,
            headers: { "X-CSRF-TOKEN": $("input[name='_token']").val() },

            success: function (msg) {
                this._resultContent = msg;
                callback(this._resultContent, 200);
                hideLoading();
            },
            error: function (xhr, status) {
                hideLoading();
                this._resultContent = {};
                if (xhr.status == 422) {
                    var errores = "";
                    errors = xhr.responseJSON;
                    $.each(errors.errors, function (key, value) {
                        errores += value[0] + "\n";
                    });
                    if (errores.trim() != "") {
                        this._resultContent = { message: errores, code: 422 };
                    }
                } else {
                    console.log(xhr);
                    if (xhr.status == "404") {
                        this._resultContent = {
                            message: "C\u00F3digo o Pagina no encontrado",
                            code: 404,
                        };
                    } else {
                        this._resultContent = {
                            message:
                                "Error de procesamiento (cod: " +
                                xhr.status +
                                ")\n" +
                                xhr.responseText,
                            code: 500,
                        };
                    }
                }

                callback(this._resultContent, xhr.status);
            },
            beforeSend: function () {
                showLoading();
            },
        });
    };
    function ajaxrequest(rtndata) {}
};
var AJAXRest = function (path, parameters, typeAjax) {
    this._path = path;
    this._parameters = parameters;
    this._vType = typeAjax.trim();
    this._resultContent = {};
    this.extractDataAjax = function (callback) {
        $.ajax({
            url: this._path,
            data: this._parameters,
            dataType: "json",
            headers: { "X-CSRF-TOKEN": $("input[name='_token']").val() },
            method: this._vType,
            success: function (msg) {
                this._resultContent = msg;
                callback(this._resultContent, 200);
                hideLoading();
            },
            error: function (xhr, status) {
                hideLoading();
                this._resultContent = {};
                if (xhr.status == 422) {
                    var errores = "";
                    errors = xhr.responseJSON;
                    $.each(errors.errors, function (key, value) {
                        errores += value[0] + "\n";
                    });
                    if (errores.trim() != "") {
                        this._resultContent = { message: errores, code: 422 };
                    }
                } else {
                    if (xhr.status == "404") {
                        this._resultContent = {
                            message: "C\u00F3digo o Pagina no encontrado",
                            code: 404,
                        };
                    } else {
                        this._resultContent = {
                            message:
                                "Error de procesamiento (cod: " +
                                xhr.status +
                                ")\n" +
                                xhr.responseText,
                            code: 500,
                        };
                    }
                }

                callback(this._resultContent, xhr.status);
            },
            beforeSend: function () {
                showLoading();
            },
        });
    };
    function ajaxrequest(rtndata) {}
};

function validateEmail(email) {
    var re =
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateNumber(number) {
    var re = /^[0-9]+$/;
    return re.test(number);
}
function buscarErroresInput(clase = null) {
    $(".erroresInput").addClass("hidden");
    var errores = false;
    if (clase != null) clase = "." + clase;
    else clase = "";
    $(".b-requerido" + clase + "").each(function () {
        var value = $(this).val();
        let maximo = "";
        var placeholder =
            typeof $(this).attr("placeholder") === "undefined"
                ? typeof $(this).attr("placeholder_") === "undefined"
                    ? $(this).attr("name")
                    : $(this).attr("placeholder_")
                : $(this).attr("placeholder");
        maxlength = $(this).attr("maxLength");
        if ($(this).hasClass("valor_maximo")) {
            if (typeof maxlength === "undefined") {
                $(this).attr("maxLength", 250);
                maxlength = $(this).attr("maxLength");
            }
            maximo = "máximo: " + maxlength + " caracteres";
        }
        var id = $(this).attr("id");
        var texto = "";
        var cargarError = $(this).next();
        if (!cargarError.hasClass("erroresInput")) {
            let li = document.createElement("span");
            li.setAttribute("style", "color:red");
            li.setAttribute("class", "erroresInput hidden");
            //   insertAfter(li,  $(this));
            $(
                '<span style="color:red" class="erroresInput hidden">Error</span>'
            ).insertAfter($(this));
            cargarError = $(this).next();
        }
        if (value == null || value == "") {
            cargarError.removeClass("hidden");
            texto +=
                "\n" +
                "Error: Se requiere llenar el campo: " +
                placeholder +
                " " +
                maximo;
            errores = true;
        }
        if (value != null && value != "") {
            //validaciones

            if ($(this).hasClass("b-correo")) {
                var regex =
                    /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                if (!regex.test(value)) {
                    cargarError.removeClass("hidden");
                    texto +=
                        "\n" + cargarError.text() + "\n" + "Correo invalido";
                    errores = true;
                }
            }
        }

        if (errores) cargarError.text(texto);
    });

    return errores;
}

$(".numero").on({
    focus: function (event) {
        $(event.target).select();
    },
    keyup: function (event) {
        $(event.target).val(function (index, value) {
            var vari = value.replace(/\D/g, "");
            return vari;
        });
    },
});

function calcular_edad_perfil(value, anio = true) {
    var anios = "";
    if (value != null && value != "") {
        let suEdad = edad(value);

        if (suEdad)
            anios = `${suEdad[0]} año(s), ${suEdad[1]} mes(es) y ${suEdad[2]} día(s).`;
        else anios = "";

        if (anios != "" && anio) {
            anios = `${suEdad[0]}`;
        }
    }

    return anios;
}
const edad = (fechaNac) => {
    if (!fechaNac || isNaN(new Date(fechaNac))) return;
    const hoy = new Date();
    const dateNac = new Date(fechaNac);
    if (hoy - dateNac < 0) return;
    let dias = hoy.getUTCDate() - dateNac.getUTCDate();
    let meses = hoy.getUTCMonth() - dateNac.getUTCMonth();
    let years = hoy.getUTCFullYear() - dateNac.getUTCFullYear();
    if (dias < 0) {
        meses--;
        dias = 30 + dias;
    }
    if (meses < 0) {
        years--;
        meses = 12 + meses;
    }

    return [years, meses, dias];
};
$(".cedula").on({
    blur: function (event) {
        $(event.target).val(function (index, value) {
            if ($("[name='errorCedula']").text() != "Cedula válida") {
                alertToast("Corrija la Cédula antes de grabar", 3500);
                return "";
            }
            return value;
        });
    },
    keyup: function (event) {
        $(event.target).val(function (index, value) {
            var cedula = value;
            if (cedula.length == 10) {
                //Obtenemos el digito de la region que sonlos dos primeros digitos
                var digito_region = cedula.substring(0, 2);
                //Pregunto si la region existe ecuador se divide en 24 regiones
                if (digito_region >= 1 && digito_region <= 30) {
                    // Extraigo el ultimo digito
                    var ultimo_digito = cedula.substring(9, 10);
                    //Agrupo todos los pares y los sumo
                    var pares =
                        parseInt(cedula.substring(1, 2)) +
                        parseInt(cedula.substring(3, 4)) +
                        parseInt(cedula.substring(5, 6)) +
                        parseInt(cedula.substring(7, 8));
                    //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
                    var numero1 = cedula.substring(0, 1);
                    var numero1 = numero1 * 2;
                    if (numero1 > 9) {
                        var numero1 = numero1 - 9;
                    }
                    var numero3 = cedula.substring(2, 3);
                    var numero3 = numero3 * 2;
                    if (numero3 > 9) {
                        var numero3 = numero3 - 9;
                    }

                    var numero5 = cedula.substring(4, 5);
                    var numero5 = numero5 * 2;
                    if (numero5 > 9) {
                        var numero5 = numero5 - 9;
                    }

                    var numero7 = cedula.substring(6, 7);
                    var numero7 = numero7 * 2;
                    if (numero7 > 9) {
                        var numero7 = numero7 - 9;
                    }

                    var numero9 = cedula.substring(8, 9);
                    var numero9 = numero9 * 2;
                    if (numero9 > 9) {
                        var numero9 = numero9 - 9;
                    }
                    var impares =
                        numero1 + numero3 + numero5 + numero7 + numero9;

                    //Suma total
                    var suma_total = pares + impares;

                    //extraemos el primero digito
                    var primer_digito_suma = String(suma_total).substring(0, 1);

                    //Obtenemos la decena inmediata
                    var decena = (parseInt(primer_digito_suma) + 1) * 10;

                    //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
                    var digito_validador = decena - suma_total;

                    //Si el digito validador es = a 10 toma el valor de 0
                    if (digito_validador == 10) var digito_validador = 0;

                    //Validamos que el digito validador sea igual al de la cedula
                    if (digito_validador == ultimo_digito) {
                        $("[name='errorCedula']").text("Cedula válida");
                    } else {
                        $("[name='errorCedula']").text("Cedula no válida");
                    }
                } else {
                    // imprimimos en consola si la region no pertenece
                    console.log("Esta cedula no pertenece a ninguna region");
                    $("[name='errorCedula']").text("Cedula no válida");
                }
            } else {
                //imprimimos en consola si la cedula tiene mas o menos de 10 digitos
                console.log("Esta cedula tiene menos de 10 Digitos");
                $("[name='errorCedula']").text("Cedula no válida");
            }
            return value;
        });
    },
});

$(".decimal").keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g, "");
});
function validarFechasEntradas(fecha_inicio, fecha_fin, maximo = 31) {
    if (
        fecha_inicio == "null" ||
        fecha_fin == "null" ||
        fecha_inicio == "0" ||
        fecha_fin == "0" ||
        fecha_inicio == "" ||
        fecha_fin == "" ||
        fecha_inicio == null ||
        fecha_fin == null
    ) {
        alertToast("Debe colocar un rango de fecha", 3500);
        return false;
    }
    var fecha1 = moment(fecha_inicio);
    var fecha2 = moment(fecha_fin);
    var fecha3 = fecha2.diff(fecha1, "days");
    if (fecha3 > maximo) {
        alertToast(
            "Los rangos de fechas no pueden extender a " + maximo + " dias",
            3500
        );
        return false;
    }
    if (fecha3 < 0) {
        alertToast(
            "La fecha de inicio no puede ser mayor a la fecha fin",
            3500
        );
        return false;
    }
    return true;
}