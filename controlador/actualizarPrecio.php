<?php 
require_once "../modelos/ActualizarPrecio.php";
 
$actualizarProducto=new ActualizarPrecio();
 
$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$precioactual=isset($_POST["precioactual"])? limpiarCadena($_POST["precioactual"]):"";
$nuevoprecio=isset($_POST["nuevoprecio"])? limpiarCadena($_POST["nuevoprecio"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        $rspta=$actualizarProducto->editar($idproducto,$nuevoprecio);
        echo $rspta ? "producto actualizado" : "producto no se pudo actualizar";
    break;

    case 'mostrar':
        $rspta=$actualizarProducto->mostrar($idproducto);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listar':
        $rspta=$actualizarProducto->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button data-toggle="tooltip" data-placement="right" title="Editar Precio" class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->precio_actual
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;

}
?>