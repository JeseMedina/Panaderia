<?php 
session_start();
require_once "../modelos/Usuario.php";
 
$usuario=new Usuario();
 //almaceno los valores de cada uno de los objetos del form
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
 
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
        {
            $imagen=$_POST["imagenactual"];
        }
        else
        {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
            {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
            }
        }

        //HASH sha256 en la contraseña
        $clavehash=hash("SHA256",$clave);
        if (empty($idusuario)){
            $rspta=$usuario->insertar($nombre,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);

            echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del Usuario";
        }
        else {
            $rspta=$usuario->editar($idusuario,$nombre,$num_documento,$direccion,$telefono,$email,$cargo,$login, $clavehash,$imagen,$_POST['permiso']);
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
    break;
 
    case 'desactivar':
        $rspta=$usuario->desactivar($idusuario);
        echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
        
    break;
 
    case 'activar':
        $rspta=$usuario->activar($idusuario);
        echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        
    break;
 
    case 'mostrar':
        $rspta=$usuario->mostrar($idusuario);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        
    break;
 
    case 'listar':
        $rspta=$usuario->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            if ($reg->imagen == ''){
                $imagen = 'Ninguna';
            }else{
                $imagen = "<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >";
            }

            $data[]=array(
                "0"=>($reg->condicion)?'<button title="Mostrar Usuario" class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button title="Desactivar Usuario" class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
                    '<button title="Mostrar Usuario" class="btn btn-primary" title="Editar usuario disabled"><i class="fa fa-pencil"></i></button>'.
                    ' <button title="Activar Usuario" class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->num_documento,
                "3"=>$reg->direccion,
                "4"=>$reg->telefono,
                "5"=>$reg->email,
                "6"=>$reg->cargo,
                "7"=>$reg->login,
                "8"=>$imagen,
                "9"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
                '<span class="label bg-red">Desactivado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
    case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar();
        
        //Obtener permisos asignados al usuario
        $id=$_GET['id'];
        $marcados = $usuario->listarmarcados($id);
        //declaramos un array para aalmacenar todos los permisos marcados
        $valores=array();
        //almacenar los permisos asignados al usuario en el array
        while ($per=$marcados->fetch_object()) 
        {
            array_push($valores,$per->idpermiso);
        }

        //Mostramos la lista permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object()) 
        {
            $sw=in_array($reg->idpermiso, $valores)?'checked':'';
            echo '<li> <input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';   
        }
    break;
    
    case 'verificar':
        
        $logina=$_POST['logina'];
        $clavea=$_POST['clavea'];

        //SHA256
        $clavehash=hash("SHA256",$clavea);
        $rspta=$usuario->verificar($logina,$clavehash);
        $fetch=$rspta->fetch_object();
        if (isset($fetch)) 
        {
            //declaramos las variables de sesión
            $_SESSION['idusuario']=$fetch->idusuario;
            $_SESSION['nombre']=$fetch->nombre;
            $_SESSION['imagen']=$fetch->imagen;
            $_SESSION['login']=$fetch->login;
            
            //obtenemos los permisos de usuario
            $marcados = $usuario->listarmarcados($fetch->idusuario);
            //Declaramos un array para almacenar todos los permisos marcados
            $valores=array();
            //almacenamos los registros marcados en el array
            while ($per=$marcados->fetch_object()) 
            {
                array_push($valores,$per->idpermiso);
            }
            //determinamos los accesos de usuario
            in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
            in_array(2,$valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
            in_array(3,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
            in_array(4,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
            in_array(5,$valores)?$_SESSION['personas']=1:$_SESSION['personas']=0;
            in_array(6,$valores)?$_SESSION['consulta']=1:$_SESSION['consulta']=0;
            in_array(7,$valores)?$_SESSION['produccion']=1:$_SESSION['produccion']=0;
            in_array(8,$valores)?$_SESSION['reparto']=1:$_SESSION['reparto']=0;
        }
        echo json_encode($fetch);

    break;

    case 'verificarOlvido':
        $login=$_POST['login'];
        $dni=$_POST['dni'];

        $rspta=$usuario->verificarOlvido($login,$dni);
        $fetch=$rspta->fetch_object();

        echo json_encode($fetch);
    break;

    case 'cambiarContrasena':
        $login=$_POST['login'];
        $clave=$_POST['clave'];

        //SHA256
        $clavehash=hash("SHA256",$clave);
        $rspta=$usuario->cambiarContrasena($login,$clavehash);
        $fetch=$rspta->fetch_object();

        echo json_encode($fetch);
    break;

    case 'salir':
        //limpiamos las variables de session
        session_unset();
        //destruimos la sessión
        session_destroy();
        //redireccionamos al login
        header("location:../index.php");
    break;

    
 
}
?>
