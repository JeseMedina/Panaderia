<?php 
require_once "../modelos/producto.php";
 
$producto=new Producto();
 
$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idrubro=isset($_POST["idrubro"])? limpiarCadena($_POST["idrubro"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$uMedida=isset($_POST["uMedida"])? limpiarCadena($_POST["uMedida"]):"";
$precioCosto=isset($_POST["precioCosto"])? limpiarCadena($_POST["precioCosto"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idproducto)){
            $rspta=$producto->insertar($idrubro,$codigo,$nombre,$stock,$uMedida,$precioCosto);
            echo $rspta ? "producto registrado" : "producto no se pudo registrar";
        }
        else {
            $rspta=$producto->editar($idproducto,$idrubro,$codigo,$nombre,$stock,$uMedida,$precioCosto);
            echo $rspta ? "producto actualizado" : "producto no se pudo actualizar";
        }
    break;
 
    case 'desactivar':
        $rspta=$producto->desactivar($idproducto);
        echo $rspta ? "producto Desactivado" : "producto no se puede desactivar";
    break;
 
    case 'activar':
        $rspta=$producto->activar($idproducto);
        echo $rspta ? "producto activado" : "producto no se puede activar";
    break;
 
    case 'mostrar':
        $rspta=$producto->mostrar($idproducto);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listar':
        $rspta=$producto->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-primary" title="Editar producto disabled"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->rubro,
                "3"=>$reg->stock,
                "4"=>$reg->uMedida,
                "5"=>$reg->precioCosto,
                "6"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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
 
    case "selectrubro":
        require_once "../modelos/rubro.php";
        $rubro = new rubro();
 
        $rspta = $rubro->select();
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->idrubro . '>' . $reg->nombre . '</option>';
                }
    break;
}
?>