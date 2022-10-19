<?php 
require_once "../modelos/rubro.php";

$rubro=new Rubro();

$idrubro=isset($_POST["idrubro"])? limpiarCadena($_POST["idrubro"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idrubro)){
			$rspta=$rubro->insertar($nombre,$descripcion);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$rubro->editar($idrubro,$nombre,$descripcion);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$rubro->desactivar($idrubro);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
 		
	break;

	case 'activar':
		$rspta=$rubro->activar($idrubro);
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
 		
	break;

	case 'mostrar':
		$rspta=$rubro->mostrar($idrubro);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		
	break;

	case 'listar':
		$rspta=$rubro->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button title="Mostrar Rubro" class="btn btn-warning" onclick="mostrar('.$reg->idrubro.')"><i class="fa fa-pencil"></i></button>'.
 					' <button title="Desactivar Rubro" class="btn btn-danger" onclick="desactivar('.$reg->idrubro.')"><i class="fa fa-close"></i></button>':
 					'<button title="Mostrar Rubro" class="btn btn-primary" onclick="mostrar('.$reg->idrubro.')"><i class="fa fa-pencil"></i></button>'.
 					' <button title="Activar Rubro" class="btn btn-primary" onclick="activar('.$reg->idrubro.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->descripcion,
 				"3"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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
}
?>