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
    $.post("../controlador/produccion.php?op=selectProducto", function(r){
        $("#idproductoproducido").html(r);
        $('#idproductoproducido').selectpicker('refresh');
    });;
}

//Función limpiar
function limpiar() {
    $("#idpanadero").val("");
    $("#idproductoproducido").val("");
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

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#formulariover").hide();
        $("#btnagregar").hide();
        $("#divmostrar").hide();
        listarProductos();

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
            "iDisplayLength": 10,//Paginación
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
            "iDisplayLength": 10,//Paginación
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
        $("#divmostrar").show();

        $("#idproduccion").val(data.idproduccion);
        $("#idpanadero").val(data.idpanadero);
        $("#idpanadero").selectpicker('refresh');
        $("#idproductoproducido").val(data.idproductoproducido);
        $("#idproductoproducido").selectpicker('refresh');
        $("#cantidadproducida").val(data.cantidadproducida);
        $("#umedida").val(data.uMedida);
        $("#preciomayorista").val(data.preciomayorista);
        $("#preciominorista").val(data.preciominorista);
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

var cont=0;
$("#btnGuardar").hide();

function agregarDetalle(idproducto, producto, uMedida) {
    var cantidad = 1;

    if (idproducto != "") {
        var fila = '<tr class="filas" id="fila' + cont + '">' +
            '<td><button data-toggle="tooltip" data-placement="right" title="Eliminar Detalle" type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button></td>' +
            '<td><input type="hidden" name="idproducto[]" value="' + idproducto + '">' + producto + '</td>' +
            '<td><input type="number" name="cantidad[]" step=".01" id="cantidad[]" value="' + cantidad + '"></td>' +
            '<td>' + uMedida + '</td>';
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