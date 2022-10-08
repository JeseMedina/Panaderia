var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
    
    $.post("../controlador/produccion.php?op=selectPanadero", function (r) {
        $("#idpanadero").html(r);
        $('#idpanadero').selectpicker('refresh');
    });
    $.post("../controlador/produccion.php?op=selectPanaderia", function(r){
        $("#idproducto").html(r);
        $('#idproducto').selectpicker('refresh');
    });;
}

//Función limpiar
function limpiar() {
    $("#idpanadero").val("");
    $("#idpanadero").val("");
    $("#idproducto").val("");


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
                url: '../controlador/produccion.php?op=listar',
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
                url: '../controlador/produccion.php?op=listarMateriaPrima',
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
        url: "../controlador/produccion.php?op=guardaryeditar",
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

function mostrar(idproduccion) {
    $.post("../controlador/produccion.php?op=mostrar", { idproduccion: idproduccion }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#idproduccion").val(data.idproduccion);
        $("#idpanadero").val(data.idpanadero);
        $("#idpanadero").selectpicker('refresh');
        $("#idproducto").val(data.idpproducto);
        $("#idproducto").selectpicker('refresh');
        $("#fecha_hora").val(data.fecha);

        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").hide();
    });

    $.post("../controlador/produccion.php?op=listarDetalle&id="+idproduccion,function(r){
        $("#detalles").html(r);
    });
}

//Función para finalizar registros
function finalizar(idproduccion) {
    bootbox.confirm("¿Está Seguro de finalizar la venta?",function(result){
        if (result) {
            $.post("../controlador/produccion.php?op=finalizar", { idproduccion: idproduccion }, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

function iniciar(idproduccion) {
    bootbox.confirm("¿Está Seguro de inicar la venta?",function(result){
        if (result) {
            $.post("../controlador/produccion.php?op=inicar", { idproduccion: idproduccion }, function (e) {
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

function agregarDetalle(idproducto, producto, uMedida) {
    var cantidad = 1;

    if (idproducto != "") {
        var fila = '<tr class="filas" id="fila' + cont + '">' +
            '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button></td>' +
            '<td><input type="hidden" name="idproducto[]" value="' + idproducto + '">' + producto + '</td>' +
            '<td><input type="number" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>' +
            '<td>' + uMedida + '</td>' +
            '</tr>';
        cont++;
        detalles=detalles+1;
        $('#detalles').append(fila);
        evaluar();
    }
    else {
        alert("Error al ingresar el detalle, revisar los datos del producto");
    }
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