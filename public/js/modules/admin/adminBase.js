$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        $("#dtmenu").hide();

    });
});


$("#btnEstado").on('click', function () {
    $("#dtmenu").show();

});
function limpiar()
{}
function recargar()
{
    $('#dtmenu').dataTable()._fnAjaxUpdate();

}
$("#btnGuardar").on('click',function () {
    guardarArchivos();
});
$('Input[name*="cabecera"]').on('click', function () {
    if (this.checked) {
        $('Input[name="cabecerac"]').val(1);

    } else {
        $('Input[name="cabecerac"]').val(0);
    }

});
function guardarArchivos()
{

    var data= new FormData();
    data.append('cabecerac', $('#cabecerac').val());

    $('#ARCHIVOS').each(function(a, array)
    {
        $.each(array.files, function (k, file)
        {
            data.append('ARCHIVOS[' + k + ']', file);
        })
    });
    var objApiRest = new AJAXRestFilePOST('/admin/AdminBaseStore', data);
    objApiRest.extractDataAjaxFile(function (_resultContent,status)
    {
        if(status==200)
        {
            alertToastSuccess(_resultContent, 3500);
            $("#Modalagregar").hide();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            changeDatatable(dato);
        }
        else
        {
            alertToast(_resultContent.message, 3500);
        }
    });
}

$("#parametro").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {

        $(event.target).val(function (index, value) {
            if($("#parametro").val().substring(0,1)=='0'||$("#parametro").val().length>4)
            {
                alertToast("Si desea un numero mayor a 4 digitos deje libre el campo Cantidad",2000)
                return '';
            }

            return value.replace(/\D/g, "")
                .replace(/([0-9])$/, '$1')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, "");
        });
    },

});

function changeDatatable(dato) {
    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

    $('#dtmenu').show();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#dtmenu').DataTable(
        {
            dom: 'lBfrtip',
            buttons: [
                'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            responsive: true, "oLanguage":
                {
                    "sUrl": "/js/config/datatablespanish.json"
                },
            "lengthMenu": [[5, -1], [5, "All"]],
            "order": [[1, 'desc']],
            "searching": true,
            "info": false,
            "ordering": false,
            "bPaginate": true,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "destroy": true,
            "ajax": "/admin/datatableAdminBase/"+dato,
            "columns": [

                {data: 'name', "width": "50%"},
                {
                    data: 'estado',
                    "width": "20%",
                    "bSortable": false,
                    "searchable": false,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.estado).text();
                    }
                },
                {
                    data: 'actions',
                    "width": "20%",
                    "bSortable": false,
                    "searchable": false,
                    "targets": 0,
                    "render": function (data, type, row) {
                        return $('<div />').html(row.actions).text();
                    }
                }
            ],

        }).ajax.reload();


}
