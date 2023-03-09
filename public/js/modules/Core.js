/**
 * Created by blacksato on 19/5/2017.
 */
$(function () {
    $("form").on("submit", function () {
        $("#pageLoader").fadeIn();
    }); //submit
}); //document ready
$(function () {
    $(".pickadate")
        .datepicker({
            formatSubmit: "yyyy-mm-dd",
            format: "yyyy-mm-dd",
            selectYears: true,
            editable: true,
            autoclose: true,
            todayHighlight: true,
            orientation: "top",
        })
        .datepicker("update", "");
});
toastr.options = {
    closeButton: false,
    debug: false,
    newestOnTop: false,
    progressBar: false,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "3000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};
function alertConfirmDelete(ptext, url) {
    swal.fire(
        {
            title: "Confirmaci\u00F3n de Eliminaci\u00F3n",
            text: "Realmente desea eliminar " + ptext + "?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: true,
            closeOnCancel: true,
        },
        function (isConfirm) {
            if (isConfirm) {
                alertToastSuccess("Ejecutando proceso de eliminaci\xf3n", 3500);
                location.href = url;
            } else {
                alertToast("Acci\xf3n cancelada", 3500);
            }
        }
    );
}

function alertConfirmAction(ptext, url) {
    swal.fire(
        {
            title: "Confirmaci\u00F3n de Acciones",
            text: "Realmente desea realizar el proceso de " + ptext,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true,
        },
        function (isConfirm) {
            if (isConfirm) {
                location.href = url;
            }
        }
    );
}

function showLoading() {
    $("#pageLoader").fadeIn();
}

function hideLoading() {
    $("#pageLoader").fadeOut();
}

function alertToast(description, time = null) {
    /*
    new PNotify({
        icon:'icon-notification2',
        title: 'Notificaci\u00F3n',
        text: description,
        addclass: 'alert alert-warning alert-styled-right',
        type: 'error',
        delay:time
    });*/
    toastr["error"](description);

    // Materialize.toast(description,time);
}
function alertToastSuccess(description, time = null) {
    /* new PNotify({
         icon:'icon-notification2',
         title: 'Notificaci\u00F3n',
         text: description,
         addclass: 'alert alert-primary alert-styled-right',
         type: 'info',
         delay:time
     });*/
    toastr["success"](description);
}

function valueSelect(_name, _value) {
    $("#" + _name).select2("destroy");
    $("#" + _name).val(_value);
    $("#" + _name).select2({
        language: "es",
        width: "100%",
    });
}
