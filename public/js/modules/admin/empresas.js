var  datosArray='';
var ciudades='';
var provincias='';
$(document).ready(function () {
    $(function () {
        $("#Modalagregar").hide();
        $("#id").val(0);
        BuscarFecha();
        getCiudades();
        getProvincias();
        cargarProvincias();
    });
});
$("#identificacion").on("blur",function(){
    validar($(this));
});

function getCiudades(){
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/general/getCiudades',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            ciudades=_resultContent.message;
        }
    });
}
function getProvincias(){
    var data= new FormData();
    var objApiRest = new AJAXRestFilePOST('/general/getProvincias',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            provincias=_resultContent.message;
            cargarProvincias();
        }
    });
}
function cargarProvincias(){
    $.each(provincias, function (_key, _value) {
            $("#provincia_id").append('<option value="'+_value.id+ '">'+_value.descripcion+'</option>')
    });
}
function cargarCiudades(id){
    $("#ciudad_id").html('');
    $("#ciudad_id").val('').change();
    $("#ciudad_id").append('<option selected="selected" value="">CIUDAD</option>');
    $.each(ciudades, function (_key, _value) {
        if(_value.parametro_id==id)
        $("#ciudad_id").append('<option value="'+_value.id+ '">'+_value.descripcion+'</option>')
    });
}



$("#provincia_id").on("change",function(){
    var id=$(this).val();
    cargarCiudades(id);
});
function limpiar() {
    $("#id").val(0);
    $("#nombres").val('');
    $('#provincia_id').val('').change();
    $('#ciudad_id').val('').change();
    $("#convencional").val('');
    $("#direccion").val('');
    $("#descripcion").val('');
}
function BuscarFecha() {
    data = new FormData();
    var objApiRest = new AJAXRestFilePOST('/empresa/getDatatable', data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            var dt = {
                draw: 1,
                recordsFiltered: _resultContent.datos.length,
                recordsTotal: _resultContent.datos.length,
                data: _resultContent.datos
            };
            datosArray=_resultContent.datos;
            $("#tablaConsulta").attr('style','margin-top:10px');

            $('#tbobymenu').show();
            $.fn.dataTable.ext.errMode = 'throw';
            $("#dtmenu").dataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<img src="/images/icons/excel.png" width="25px" heigh="20px">',
                        titleAttr: 'Excel'
                    },
                 
                    {
                        extend:    'pdfHtml5',
                        text:      '<img src="/images/icons/pdf.png" width="25px" heigh="20px">',
                        titleAttr: 'PDF',
                        orientation: 'landscape',
                       /* exportOptions: {
                            columns: [0, 1,2,3,4,5,6,7,8,9,10] //exportar solo la primera y segunda columna
                        },*/
                        title:'.',
                        footer: true,
                        pageSize: 'A4',
                        filename:'Empresas- ISOCORE'
                        
                    }
                ],
                "lengthMenu": [[5, -1], [5, "TODOS"]],
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "draw": dt.draw,
                "destroy":true,
                "recordsFiltered": dt.recordsFiltered,
                "recordsTotal": dt.recordsTotal,
                "data": dt.data,
                "order": [[1, "desc"]],
                "language": {
                    "search":"Buscar",
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "Lo sentimos, no encontramos lo que estas buscando",
                    "info": "Motrar página _PAGE_ de _PAGES_",
                    "infoEmpty": "Registros no encontrados",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "infoFiltered": "(Filtrado en MAX registros totales)",
                    },
                "columnDefs": [
                    { "targets": [0], "orderable": true }
                ],
                "columns": [
                  
                            {title:'N&deg;',data: 'id', "width": "5%"},
                         
                            {title:'Empresa',data: 'nombres', "width": "15%"
                            },
                            {title:'Direccion',data: 'direccion', "width": "15%"
                            },
                            {title:'Telefono',data: 'telefono', "width": "15%"
                               
                            },
                             {title:'Estado',data: 'estado', "width": "15%"
                                ,"render": function (data, type, row) {
                                    var created_at='--';
                                     $act='<span class="label label-info">ACTIVO</span>';
                                    if(row.estado!='A')
                                    $act='<span class="label label-warning">INACTIVO</span>';
                                    
                                    return $act;
                                }
                            },
                            {
                                title:'',
                                  data: 'actions',
                                  "width": "5%",
                                  "bSortable": false,
                                  "searchable": false,
                                  "targets": 0,
                                  "render": function (data, type, row) {
                                    return '<a href="#" onclick="Actualizar(\'' + row.id + '\');"data-hover="tooltip" data-placement="top" data-target="#Modalagregar" data-toggle="modal" id="modal"'+ 
                                                        'class="label label-primary">'+
                                                        '<span class="glyphicon glyphicon-edit"></span></a>'+
                                                        '<a href="#" onclick="PedirConfirmacion(\'' + row.id + '\',\'eliminar\');"'+
                                                        'class="label label-danger">'+
                                                        '<span class="fa fa-sync"></span></a>';
                                  }
                              },

                ],
            });

        } else {
            alertToast(_resultContent.message, 3500);
        }
    });
     
}
function Eliminar(id)
{

    var data= new FormData();
    data.append('id', id);

    var objApiRest = new AJAXRestFilePOST('/empresa/EliminarEmpresa',  data);
    objApiRest.extractDataAjaxFile(function (_resultContent) {
        if (_resultContent.status == 200) {
            alertToastSuccess(_resultContent.message,3500);
            BuscarFecha();
        } else {
            alertToast(_resultContent.message,3500);
        }
    });
}

function Actualizar(id) {
    $('body').attr('style','overflow-y: hidden!important;');
 
    var data = $.grep(datosArray, function (element, index) {
        return element.id == id;
    });
    data=data[0];
 
    var id = $("#id").val(data['id']);

    var provincia_id = $('#provincia_id').val(data['provincia_id']).change();
    var ciudad_id = $('#ciudad_id').val(data['ciudad_id']).change();
    var convencional = $("#convencional").val(data['telefono']);
    var nombres = $("#nombres").val(data['nombres']);
    var direccion = $("#direccion").val(data['direccion']);
    var descripcion = $("#descripcion").val(data['descripcion']);

    $("#Modalagregar").show();


}

$("#btnGuardar").on('click', function () {

    var tipo="crea";
    var errores = [];
    var id=$("#id").val();
    var nombres = $("#nombres").val();
    var descripcion = $("#descripcion").val();
    var provincia_id = $('#provincia_id').val();
    var ciudad_id = $('#ciudad_id').val();
    var convencional = $("#convencional").val();
    var direccion= $("#direccion").val();

    if (nombres.length < 1) {
        alertToast("EL campo nombre de la empresa es obligatorio",3500);
        return false;
    }
    if (descripcion.length < 1) {
        alertToast("EL campo descripcion de la empresa es obligatorio",3500);
        return false;
    }  if (ciudad_id=='') {
        alertToast("EL campo ciudad de la empresa es obligatorio",3500);
        return false;
    }  if (provincia_id=='') {
        alertToast("EL campo provincia de la empresa es obligatorio",3500);
        return false;
    }  if (convencional.length < 1) {
        alertToast("EL campo convencional de la empresa es obligatorio",3500);
        return false;
    }  if (direccion.length < 1) {
        alertToast("EL campo direccion de la empresa es obligatorio",3500);
        return false;
    }  

    if(id!=''&&id!=null&&id!=0)
        tipo='actualiza';

        var data= new FormData();
        data.append('id', id);
        data.append('nombres', nombres);
        data.append('descripcion', descripcion);
        data.append('ciudad_id', ciudad_id);
        data.append('provincia_id', provincia_id);
        data.append('convencional', convencional);
        data.append('direccion', direccion);
        data.append('tipo', tipo);

        var objApiRest = new AJAXRestFilePOST('/empresa/saveEmpresa',  data);
        objApiRest.extractDataAjaxFile(function (_resultContent) {
            if (_resultContent.status == 200) {
                alertToastSuccess(_resultContent.message,3500);
                BuscarFecha();
                $("#btnCancelar").click();
            } else {
                alertToast(_resultContent.message,3500);
    
            }
        });


});
