function init() {
    cajaAbierta();
    mostrarTotal();

    $("#formulario").on("submit", function (e) {
        retirarEfectivo(e);
    });
}

function limpiar() {
    $("#idcaja").val("");
    $("#retiro").val("");
    $("#total").val("");

}

function mostrarTotal(){
    $.post("../controlador/caja.php?op=listarCajaId", function(data, status)
    {
        data = JSON.parse(data);
        $("#idcaja").val(data.idcaja);
        $("#total").val(data.total);
    });
}

function retirarEfectivo(e){
    e.preventDefault();
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/caja.php?op=retirarEfectivo",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
        }

    });
    limpiar();
    mostrarTotal();
}

function cajaAbierta(){
    $.post("../controlador/caja.php?op=cajaAbierta", function(r){
        if(r == 0){
            alert("Debe Abrir la Caja antes de Comenzar a Comprar");
            window.location.href = "caja.php";
        }
    });
}

init();