var tabla;
 
//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);  
    })
 
    //Cargamos los items al select rubro
    $.post("../controlador/producto.php?op=selectrubro", function(r){
                $("#idrubro").html(r);
                $('#idrubro').selectpicker('refresh');
 
    });
}
 
//Función limpiar
function limpiar()
{
    $("#codigo").val("");
    $("#nombre").val("");
    $("#uMedida").val("");
    $("#stock").val("");
    $("#precioCosto").val("");
    $("#print").hide();
    $("#idproducto").val("");
}
 
//Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}
 
//Función cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
}
 
//Función Listar
function listar()
{
    tabla=$('#tbllistado').dataTable(
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
                    url: '../controlador/producto.php?op=listar',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
}
//Función para guardar o editar
 
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../controlador/producto.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
 
        success: function(datos)
        {                    
              bootbox.alert(datos);           
              mostrarform(false);
              tabla.ajax.reload();
        }
 
    });
    limpiar();
}
 
function mostrar(idproducto)
{
    $.post("../controlador/producto.php?op=mostrar",{idproducto : idproducto}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
        $("#idrubro").val(data.idrubro);
        $('#idrubro').selectpicker('refresh');
        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#uMedida").val(data.uMedida);
        $("#precioCosto").val(data.precioCosto);
        $("#idproducto").val(data.idproducto);
        generarbarcode();
 
    })
}
 
//Función para desactivar registros
function desactivar(idproducto)
{
    bootbox.confirm("¿Está Seguro de desactivar el artículo?", function(result){
        if(result)
        {
            $.post("../controlador/producto.php?op=desactivar", {idproducto : idproducto}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}
 
//Función para activar registros
function activar(idproducto)
{
    bootbox.confirm("¿Está Seguro de activar el Artículo?", function(result){
        if(result)
        {
            $.post("../controlador/producto.php?op=activar", {idproducto : idproducto}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}
 
//función para generar el código de barras
function generarbarcode()
{
    codigo=$("#codigo").val();
    JsBarcode("#barcode", codigo);
    $("#print").show();
}
 
//Función para imprimir el Código de barras
function imprimir()
{
    $("#print").printArea();
}
 
init();