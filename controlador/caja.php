<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Caja.php";

$caja = new Caja();

$idcaja=isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
$inicio=isset($_POST["inicio"])? limpiarCadena($_POST["inicio"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$total=isset($_POST["total"])? limpiarCadena($_POST["total"]):"";
$retiro=isset($_POST["retiro"])? limpiarCadena($_POST["retiro"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idcaja)){
            $rspta=$caja->insertar($fecha_hora,$inicio);
            echo $rspta ? "Caja registrada" : "No se pudieron registrar todos los datos de la caja";
        }
    break;

    case 'mostrar':
        $rspta=$caja->mostrar($idcaja);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta=$caja->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>(($reg->estado=='Abierta')?'<button title="Cerrar Caja" class="btn btn-danger" onclick="cerrarCaja('.$reg->idcaja.')"><i class="fa fa-check"></i></button>':'<span></span>'),
                "1"=>$reg->fecha,
                "2"=>$reg->inicio,
                "3"=>$reg->ingreso,
                "4"=>$reg->egreso,
                "5"=>$reg->total,
                "6"=>($reg->estado=='Abierta')?'<span class="label bg-green">Abierta</span>':
                '<span class="label bg-red">Cerrada</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;

    case 'cerrarCaja':
        $rspta=$caja->cerrarCaja($idcaja);
        echo $rspta ? "Caja Cerrada" : "caja no se pudo Cerrar";
    break;

    case 'cajaAbierta':
        $rspta=$caja->cajaAbierta($idcaja);
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->idcaja
                );
        }
        echo sizeof($data);
    break;

    case 'listarCajaId':
        $rspta=$caja->listarCajaId();
        echo json_encode($rspta);
    break;
    
    case 'retirarEfectivo':
        $rspta=$caja->retirarEfectivo($idcaja,$retiro);
        echo $rspta ? "Efectivo Retirado" : "No se pudo retirar Efectvo";
    break;
    
}
?>
