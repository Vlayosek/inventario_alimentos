$(function () {
    $("#tbUsers")
        .DataTable({
            responsive: true,
            lengthMenu: [
                [5, 10, 20, 30],
                [5, 10, 20, 30],
            ],
            lengthChange: true,
            autoWidth: true,
            language: {
                search: "Buscar",
                lengthMenu: "Mostrar _MENU_",
                zeroRecords:
                    "Lo sentimos, no encontramos lo que estas buscando",
                info: "Motrar página _PAGE_ de _PAGES_ (_TOTAL_)",
                infoEmpty: "Registros no encontrados",
                oPaginate: {
                    sFirst: "Primero",
                    sLast: "Último",
                    sNext: "Siguiente",
                    sPrevious: "Anterior",
                },
                infoFiltered: "(Filtrado _TOTAL_ de _MAX_ registros totales)",
            },
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<img src="/images/icons/excel.png" width="25px" heigh="20px">',
                    titleAttr: "Excel",
                },

                {
                    extend: "pdfHtml5",
                    text: '<img src="/images/icons/pdf.png" width="25px" heigh="20px">',
                    titleAttr: "PDF",
                    orientation: "landscape",
                    //  title:'REGISTRADOS',
                    footer: true,
                    pageSize: "A4",
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#tbUsers_wrapper .col-md-6:eq(0)");

    $("#tbRoles")
        .DataTable({
            responsive: true,
            lengthMenu: [
                [5, 10, 20, 30],
                [5, 10, 20, 30],
            ],
            lengthChange: true,
            autoWidth: true,
            language: {
                search: "Buscar",
                lengthMenu: "Mostrar _MENU_",
                zeroRecords:
                    "Lo sentimos, no encontramos lo que estas buscando",
                info: "Motrar página _PAGE_ de _PAGES_ (_TOTAL_)",
                infoEmpty: "Registros no encontrados",
                oPaginate: {
                    sFirst: "Primero",
                    sLast: "Último",
                    sNext: "Siguiente",
                    sPrevious: "Anterior",
                },
                infoFiltered: "(Filtrado _TOTAL_ de _MAX_ registros totales)",
            },
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<img src="/images/icons/excel.png" width="25px" heigh="20px">',
                    titleAttr: "Excel",
                },

                {
                    extend: "pdfHtml5",
                    text: '<img src="/images/icons/pdf.png" width="25px" heigh="20px">',
                    titleAttr: "PDF",
                    orientation: "landscape",
                    footer: true,
                    pageSize: "A4",
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#tbRoles_wrapper .col-md-6:eq(0)");
});
