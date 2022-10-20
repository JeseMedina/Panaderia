function init(){
    mostrarform(false);

    $("#frmOlvido").on("submit",function(e)
    {
        validar(e);
    })

    $("#frmCambiar").on("submit",function(e)
    {
        cambiarContrasena(e);
    })
}

function mostrarform(flag)
{
    if (flag)
    {
        $("#divCambiar").show();
        $("#divOlvido").hide();
    }
    else
    {
        $("#divCambiar").hide();
        $("#divOlvido").show();
    }
}

function limpiar(){
    $("#login").val("");
    $("#dni").val("");
    $("#clave1").val("");
    $("#clave2").val("");
}

function validar(e){
    e.preventDefault();
	login=$("#login").val();
	dni=$("#dni").val();

    $.post("../controlador/usuario.php?op=verificarOlvido",
		{"login":login,"dni":dni},
		function(data)
		{
			if (data!="null") 
			{
				mostrarform(true);
			}
			else
			{
				bootbox.alert("Usuario y/o DNI incorrectos. Intentelo Nuevamente");
                
			}
		});
}

function cambiarContrasena(e){
    e.preventDefault();
    login=$("#login").val();
    clave1=$("#clave1").val();
    clave2=$("#clave2").val();

    if(clave1 == clave2){
        $.post("../controlador/usuario.php?op=cambiarContrasena",
		{"login":login,"clave":clave1},
		function(data)
		{
			if (data!="null") 
			{
				$(location).attr("href","login.html");
			}
			else
			{
				bootbox.alert("No se pudo actualizar la contraseña. Intentelo Nuevamente");
                limpiar();
                mostrarform(false);
			}
		});
    }else{
        bootbox.alert("Las contraseñas deben ser iguales");
    }

    
}

init();