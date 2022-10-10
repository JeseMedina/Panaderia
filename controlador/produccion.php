<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Produccion.php";
 
$produccion=new Produccion();

$idproduccion=isset($_POST["idproduccion"])? limpiarCadena($_POST["idproduccion"]):"";
$idpanadero=isset($_POST["idpanadero"])? limpiarCadena($_POST["idpanadero"]):"";
$idproducto=isset($_POST["idproducto"]);
// ? limpiarCadena($_POST["idproducto"]):"";
$cantidadproducida=isset($_POST["cantidadproducida"])? limpiarCadena($_POST["cantidadproducida"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$precio_venta=isset($_POST["precio_venta"])? limpiarCadena($_POST["precio_venta"]):"";

switch ($_GET["op"]){
    case 'guardar':
        if (empty($idproduccion)){
            $rspta=$produccion->insertar($idpanadero,$idproducto,$fecha_hora,$_POST["idmateria"],$_POST["cantidad"]);
            echo $rspta ? "produccion registrada" : "No se pudieron registrar todos los datos de la produccion";
        }
    break;
    
    case 'finalizar':
        $rspta=$produccion->finalizar($idproduccion,$cantidadProducida,$precio_venta);
        echo $rspta ? "produccion finalizado" : "produccion no se puede finalizado";
    break;

    case 'iniciar':
        $rspta=$produccion->iniciar($idproduccion);
        echo $rspta ? "produccion iniciado" : "produccion no se puede iniciar";
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
        $total=0;
        echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Materia Prima</th>
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
                "0"=>(($reg->estado=='Iniciado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idproduccion.')"><i class="fa fa-eye"></i></button>'.
                    ' <button class="btn btn-danger" onclick="finalizarform('.$reg->idproduccion.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idproduccion.')"><i class="fa fa-eye"></i></button>'),
                "1"=>$reg->fecha,
                "2"=>$reg->panadero,
                "3"=>$reg->nombre,
                "4"=>$reg->cantidadProducida,
                "5"=>$reg->uMedida,
                "6"=>$reg->precio_venta,
                "7"=>($reg->estado=='Iniciado')?'<span class="label bg-green">Iniciado</span>':
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

    case 'selectPanadero':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarpa();
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
                }
    break;

    case 'selectPanaderia':
        require_once "../modelos/Producto.php";
        $producto = new Producto();

        $rspta = $producto->listarActivosPanaderia();

        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
                }
    break;

    case 'listarProductosProduccion':
        require_once "../modelos/Producto.php";
        $producto=new Producto();
 
        $rspta=$producto->listarActivosPanaderia();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\',\''.$reg->uMedida.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->stock,
                "3"=>$reg->uMedida,
                "4"=>$reg->precio_venta
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
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