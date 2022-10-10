var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();
    listarfinalizar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });

    $.post("../controlador/reparto.php?op=selectRepartidor", function (r) {
        $("#idrepartidor").html(r);
        $('#idrepartidor').selectpicker('refresh');
    });
    $.post("../controlador/reparto.php?op=selectCliente", function(r){
        $("#idcliente").html(r);
        $('#idcliente').selectpicker('refresh');
    });;

    

}

//Función limpiar
function limpiar() {
    $("#idcliente").val("");
    $("#idcliente").val("");
    $("#idrepartidor").val("");


    $("#total_venta").val("");
    $(".filas").remove();
    $("#total").html("0");

    //Obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $('#fecha_hora').val(today);
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarProductos();

        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        detalles = 0;
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//Función Listar
function listar() {
    tabla = $('#tbllistado').dataTable(
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
                url: '../controlador/reparto.php?op=listar',
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
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
                url: '../controlador/reparto.php?op=listarfinalizar',
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}

//Función ListarProductos
function listarProductos() {
    tabla = $('#tblproductos').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [

            ],
            "ajax":
            {
                url: '../controlador/reparto.php?op=listarProductosVenta',
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 15,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/reparto.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            listar();
        }

    });
    limpiar();
}

function mostrar(idreparto) {
    $.post("../controlador/reparto.php?op=mostrar", { idreparto: idreparto }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#idreparto").val(data.idreparto);
        $("#idcliente").val(data.idcliente);
        $("#idcliente").selectpicker('refresh');
        $("#idrepartidor").val(data.idrepartidor);
        $("#idrepartidor").selectpicker('refresh');
        $("#fecha_hora").val(data.fecha);

        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").hide();
    });

    $.post("../controlador/reparto.php?op=listarDetalle&id="+idreparto,function(r){
        $("#detalles").html(r);
    });
}

//Función para finalizar registros
function finalizar(idreparto) {
    bootbox.confirm("¿Está Seguro de finalizar el Reparto?",function(result){
        if (result) {
            $.post("../controlador/reparto.php?op=finalizar", { idreparto: idreparto }, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var cont=0;
var detalles=0;
$("#btnGuardar").hide();

function agregarDetalle(idproducto, producto, precio_venta, uMedida) {
    var cantidad = 1;
    var descuento = 0;

    if (idproducto != "") {
        var subtotal = cantidad * precio_venta;
        var fila = '<tr class="filas" id="fila' + cont + '">' +
            '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button></td>' +
            '<td><input type="hidden" name="idproducto[]" value="' + idproducto + '">' + producto + '</td>' +
            '<td><input type="number" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>' +
            '<td>' + uMedida + '</td>' +
            '<td><input type="number" name="precio_venta[]" id="precio_venta[]" value="' + precio_venta + '"></td>' +
            '<td><input type="number" name="descuento[]" value="' + descuento + '"></td>' +
            '<td><span name="subtotal" id="subtotal' + cont + '">' + subtotal + '</span></td>' +
            '<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>' +
            '</tr>';
        cont++;
        detalles=detalles+1;
        $('#detalles').append(fila);
        modificarSubototales();
    }
    else {
        alert("Error al ingresar el detalle, revisar los datos del producto");
    }
}

function modificarSubototales() {
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");

    for (var i = 0; i < cant.length; i++) {
        var inpC = cant[i];
        var inpP = prec[i];
        var inpD = desc[i];
        var inpS = sub[i];

        inpS.value = (inpC.value * inpP.value) - inpD.value;
        document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();
}

function calcularTotales() {
    var sub = document.getElementsByName("subtotal");
    var total = 0.0;

    for (var i = 0; i < sub.length; i++) {
        total += document.getElementsByName("subtotal")[i].value;
    }
    $("#total").html("S/. " + total);
    $("#total_venta").val(total);
    evaluar();
}

function evaluar() {
    if (detalles > 0) {
        $("#btnGuardar").show();
    }
    else {
        $("#btnGuardar").hide();
        cont = 0;
    }
}

function eliminarDetalle(indice) {
    $("#fila" + indice).remove();
    calcularTotales();
    detalles = detalles - 1;
    evaluar()
}

init();