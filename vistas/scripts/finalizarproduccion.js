var tabla;

function init() {
    mostrarform(false);
    listarfinalizar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
}

function limpiar() {
    $("#panadero").val("");
    $("#productoproducido").val("");
    $("#cantidadproducida").val("");
    $("#umedida").val("");
    $("#preciomayorista").val("");
    $("#preciominorista").val("");


    $(".filas").remove();

    //Obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $('#fecha_hora').val(today);
}

function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#formulariover").hide();
        $("#btnagregar").hide();

        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        detalles = 0;
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#formulariover").hide();
        $("#btnagregar").show();
    }
}

function cancelarform() {
    limpiar();
    mostrarform(false);
}

function listarfinalizar() {
    tabla = $('#tbllistadofinalizar').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":
            {
                url: '../controlador/produccion.php?op=listarfinalizar',
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/produccion.php?op=finalizar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        error: function (e) {
            console.log(e.responseText);
        },
        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            listarfinalizar();
        }

    });
    limpiar();
}

function mostrar(idproduccion) {
    $.post("../controlador/produccion.php?op=mostrar", { idproduccion: idproduccion }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#divmostrar").show();

        $("#idproduccion").val(data.idproduccion);
        $("#panadero").val(data.panadero);
        $("#productoproducido").val(data.producto);
        $("#cantidadproducida").val(data.cantidadproducida);
        $("#umedida").val(data.uMedida);
        $("#preciomayorista").val(data.preciomayorista);
        $("#preciominorista").val(data.preciominorista);
        $("#fecha_hora").val(data.fecha);

        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
        $("#btnAgregarArt").hide();
    });

    $.post("../controlador/produccion.php?op=listarDetalle&id="+idproduccion,function(r){
        $("#detalles").html(r);
    });
}

init();
