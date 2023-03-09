$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        changeDatatable();
    });
});

/* $("#name").on("change", function () {
    var name = this.value;
    if (name != "") {
        data = new FormData();
        data.append("name", name);
        var objApiRest = new AJAXRestFilePOST("/admin/PermissionRole/", data);
        objApiRest.extractDataAjaxFile(function (_resultContent, status) {
            if (status == 200) {
                $.each(_resultContent.data, function (_key, _value) {
                    $("#permission").append(
                        "<option value='" + 1 + "'>" + role + "</option>"
                    );
                });
            } else {
                alertToast(_resultContent.message, 3000);
            }
        });
    }
}); */

function ChangeListTrabTi(idcarrera, idplectivo) {
    $("#cmbEstudiante").html("");
    if (this.value != "") {
        var objApiRest = new AJAXRest(
            "/titulacion/complexivo/data-student/" +
                idcarrera +
                "/" +
                idplectivo,
            {},
            "POST"
        );
        objApiRest.extractDataAjax(function (_resultContent, status) {
            if (status == 200) {
                $("#cmbEstudiante").append(
                    "<option value='' selected='selected'> * SELECCIONE ESTUDIANTE *</option>"
                );
                $.each(_resultContent.data, function (_key, _value) {
                    $("#cmbEstudiante").append(
                        "<option value='" +
                            _value.CODIGO +
                            "'>" +
                            _value.DESCRIPCION +
                            "</option>"
                    );
                });
            } else {
                alertToast(_resultContent.message, 3000);
            }
        });
    }
}

function PedirConfirmacion(id, permiso, dato) {
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
                    DeleteChanges(id, permiso);
                    break;
            }
        } else if (result.isDenied) {
            app.cargando = false;

            swal.fire("Cancelado!", "No se registraron cambios...", "error");
            return false;
        }
    });
}

function DeleteChanges(id, permiso) {
    var objApiRest = new AJAXRest(
        "/admin/MenuRoleEliminar",
        {
            id: id,
            permiso: permiso,
        },
        "post"
    );
    objApiRest.extractDataAjax(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message, 3500);
            changeDatatable();
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
        } else {
            alertToast(_resultContent.message, 3500);
            changeDatatable();
        }
    });
}
function SaveChanges() {
    var listaTribunal = $("select[name^=permission]").val();
    var myJsonString = JSON.stringify(listaTribunal);
    var data = new FormData();

    data.append("name", $("#name").val() ? $("#name").val() : "");
    data.append("permiso", listaTribunal.length > 0 ? myJsonString : "");

    var objApiRest = new AJAXRestFilePOST("/admin/UpdateRoleP", data);
    objApiRest.extractDataAjaxFile(function (_resultContent, status) {
        if (status == 200) {
            alertToastSuccess(_resultContent, 4500);
            // window.location = "";
            setTimeout(function () {
                (location.href = "/admin/roles/"), 10000;
            });
        } else {
            alertToast(_resultContent.message, 2500);
        }
    });
}
$("#btnG").on("click", function () {
    var save = "save";
    PedirConfirmacion("0", "0", save);
});

function changeDatatable() {
    $("#dtop").DataTable().destroy();
    $("#tbobyop").html("");
    $("#dtop").show();
    $.fn.dataTable.ext.errMode = "throw";

    $("#dtop")
        .DataTable({
            responsive: true,
            oLanguage: {
                sUrl: "/js/config/datatablespanish.json",
            },
            lengthMenu: [
                [3, 5, 10, -1],
                [3, 5, 10, "All"],
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
            ajax: "/admin/datatable-option/",
            columns: [
                {
                    data: "roles",
                    width: "50%",
                    bSortable: false,
                    searchable: true,
                    targets: 0,
                    render: function (data, type, row) {
                        return $("<div />")
                            .html(row.roles.toUpperCase())
                            .text();
                    },
                },
                {
                    data: "actions",
                    width: "5%",
                    bSortable: false,
                    searchable: false,
                    targets: 0,
                    render: function (data, type, row) {
                        return $("<div />").html(row.actions).text();
                    },
                },
                {
                    data: "options",
                    width: "45%",
                    render: function (data, type, row) {
                        var div = "";
                        var codAndName = data.split(",");
                        var tribunal = null;
                        $.each(codAndName, function (key, data) {
                            tribunal = data.split("-");
                            div +=
                                "<tr>" +
                                '<td width="90%"><div style="font-size: 13px;" >' +
                                tribunal[1] +
                                ", </div></td>" +
                                '<td width="10%"><small class="btn btn-danger btn-xs" onclick="PedirConfirmacion(\'' +
                                row.id +
                                "','" +
                                tribunal[0] +
                                "', '" +
                                "delete" +
                                '\')" class="label label-danger" title="Eliminar "><i class="fas fa-trash"></i></small></td>' +
                                "</tr>";
                        });
                        return (
                            '<div><table width="100%">' + div + "</table></div>"
                        );
                    },
                },
            ],
        })
        .ajax.reload();
}
