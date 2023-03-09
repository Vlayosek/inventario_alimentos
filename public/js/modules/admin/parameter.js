$(function () {
    $("#modal-parametro").hide();
    limpiar();
    changeDatatable();
});

$("#btnGuardar").on("click", function () {
    var save = "save";
    PedirConfirmacion("0", "0", save);
});

function PedirConfirmacion(id, parameter, dato) {
    swal.fire({
        title: "¿Estas seguro de realizar esta accion?",
        text: "Al confirmar se grabaran los datos exitosamente",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si!",
        cancelButtonText: "No",
        closeOnConfirm: true,
        closeOnCancel: false,
    }).then((result) => {
        if (result.isConfirmed) {
            switch (dato) {
                case "save":
                    SaveChanges();
                    break;

                case "delete":
                    DeleteChanges(id, parameter);
                    break;
            }
        } else if (result.isDenied) {
            swal.fire("Cancelado!", "No se registraron cambios...", "error");
            return false;
        }
    });
}

function EditChanges(id, name, estado, parameter, verificacion) {
    $("#var").val(id);
    $("#father").val(parameter).change();
    $("#optionid").val(estado).change();
    // $("#verificacion").val(verificacion).change();
    $("#name").val(name);
}

function DeleteChanges(id, parameter) {
    var objApiRest = new AJAXRest(
        "/admin/ParameterEliminar",
        {
            id: id,
            parameter: parameter,
        },
        "post"
    );
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            limpiar();
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
            changeDatatable();
        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable();
        }
    });
}

function SaveChanges() {
    var objApiRest = new AJAXRest(
        "/admin/SaveParameter",
        {
            optionid: $("#optionid").val(),
            name: $("#name").val(),
            father: $("#father").val(),
            var: $("#var").val(),
            verificacion: $("#verificacion").val(),
        },
        "post"
    );
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            limpiar();
            $("#btnCancelar").trigger("click");
            changeDatatable();
        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable();
        }
    });
}

function limpiar() {
    $("#optionid").val("A").trigger("change");
    $("#name").val("");
    $("#father").val("126").trigger("change");
    $("#var").val(0);
}

function changeDatatable() {
    $("#dtmenu").DataTable().destroy();
    $("#tbobymenu").html("");

    $("#dtmenu").show();
    $.fn.dataTable.ext.errMode = "throw";
    $("#dtmenu")
        .DataTable({
            responsive: true,
            oLanguage: {
                sUrl: "/js/config/datatablespanish.json",
            },
            lengthMenu: [
                [5, -1],
                [5, "All"],
            ],
            order: [[1, "desc"]],
            searching: true,
            info: false,
            ordering: false,
            bPaginate: true,
            processing: true,
            serverSide: true,
            deferRender: true,
            destroy: true,
            ajax: "/admin/datatable-parameter/",
            language: {
                search: "Buscar",
                lengthMenu: "Mostrar _MENU_",
                zeroRecords:
                    "Lo sentimos, no encontramos lo que estas buscando",
                info: "Motrar página _PAGE_ de _PAGES_",
                infoEmpty: "Registros no encontrados",
                oPaginate: {
                    sFirst: "Primero",
                    sLast: "Último",
                    sNext: "Siguiente",
                    sPrevious: "Anterior",
                },
                infoFiltered: "(Filtrado en MAX registros totales)",
            },
            columns: [
                {
                    data: "name",
                    width: "30%",
                    searchable: true,
                    bSortable: true,
                },
                {
                    data: "padre",
                    width: "30%",
                },
                {
                    data: "estado",
                    width: "20%",
                    bSortable: false,
                    searchable: false,
                    targets: 0,
                    render: function (data, type, row) {
                        return $("<div />").html(row.estado).text();
                    },
                },
                {
                    data: "actions",
                    width: "20%",
                    bSortable: false,
                    searchable: false,
                    targets: 0,
                    render: function (data, type, row) {
                        return $("<div />").html(row.actions).text();
                    },
                },
            ],
        })
        .ajax.reload();
}
