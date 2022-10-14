<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Produccion.php";

$produccion = new Produccion();

$idproduccion=isset($_POST["idproduccion"])? limpiarCadena($_POST["idproduccion"]):"";
$idpanadero=isset($_POST["idpanadero"])? limpiarCadena($_POST["idpanadero"]):"";
$panadero=isset($_POST["panadero"])? limpiarCadena($_POST["panadero"]):"";
$idproductoproducido=isset($_POST["idproductoproducido"])? limpiarCadena($_POST["idproductoproducido"]):"";
$productoproducido=isset($_POST["productoproducido"])? limpiarCadena($_POST["productoproducido"]):"";
$cantidadproducida=isset($_POST["cantidadproducida"])? limpiarCadena($_POST["cantidadproducida"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$preciomayorista=isset($_POST["preciomayorista"])? limpiarCadena($_POST["preciomayorista"]):"";
$preciominorista=isset($_POST["preciominorista"])? limpiarCadena($_POST["preciominorista"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idproduccion)){
            $rspta=$produccion->insertar($idpanadero,$idproductoproducido,$fecha_hora,$_POST["idproducto"],$_POST["cantidad"]);
            echo $rspta ? "Produccion registrada" : "No se pudieron registrar todos los datos de la Produccion";
        }
    break;

    case 'mostrar':
        $rspta=$produccion->mostrar($idproduccion);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'listarDetalle':
        //Recibimos el idcompra
        $id=$_GET['id'];
 
        $rspta = $produccion->listarDetalle($id);
        echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>U. Medida</th>
                                </thead>';
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<tr class="filas">
                    <td></td>
                    <td>'.$reg->nombre.'</td>
                    <td>'.$reg->cantidad.'</td>
                    <td>'.$reg->uMedida.'</td>';
                }
    break;

    case 'listar':
        $rspta=$produccion->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idproduccion.')"><i class="fa fa-eye"></i></button>',
                "1"=>$reg->idproduccion,
                "2"=>$reg->fecha,
                "3"=>$reg->producto,
                "4"=>$reg->uMedida,
                "5"=>$reg->cantidadproducida,
                "6"=>$reg->preciomayorista,
                "7"=>$reg->preciominorista,
                "8"=>$reg->panadero,
                "9"=>($reg->estado=='Iniciado')?'<span class="label bg-green">Iniciado</span>':
                '<span class="label bg-red">Finalizado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;

    case 'listarfinalizar':
        $rspta=$produccion->listarfinalizar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idproduccion.')"><i class="fa fa-eye"></i></button>',
                "1"=>$reg->idproduccion,
                "2"=>$reg->fecha,
                "3"=>$reg->producto,
                "4"=>$reg->uMedida,
                "5"=>$reg->cantidadproducida,
                "6"=>$reg->preciomayorista,
                "7"=>$reg->preciominorista,
                "8"=>$reg->panadero,
                "9"=>($reg->estado=='Iniciado')?'<span class="label bg-green">Iniciado</span>':
                '<span class="label bg-red">Finalizado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;

    case 'finalizar':
        $rspta=$produccion->finalizar($idproduccion,$cantidadproducida,$preciomayorista,$preciominorista);
        echo $rspta ? "produccion Finalizado" : "produccion no se pudo finalizar";
    break;

    case 'selectPanadero':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarpa();
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
                }
    break;

    case 'selectProducto':
        require_once "../modelos/Producto.php";
        $producto = new Producto();
 
        $rspta = $producto->listarActivosPanaderia();
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idproducto . '>' . $reg->nombre . '</option>';
                }
    break;

    case 'listarMateriaPrima':
        require_once "../modelos/Producto.php";
        $producto=new Producto();
 
        $rspta=$producto->listarMateriaPrima();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->uMedida.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->stock,
                "3"=>$reg->uMedida
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