<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Reparto.php";
 
$reparto=new Reparto();

$idreparto=isset($_POST["idreparto"])? limpiarCadena($_POST["idreparto"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$idrepartidor=isset($_POST["idrepartidor"])? limpiarCadena($_POST["idrepartidor"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idreparto)){
            $rspta=$reparto->insertar($idcliente,$idusuario,$idrepartidor,$fecha_hora,$total_venta,$_POST["idproducto"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
            echo $rspta ? "Reparto registrada" : "No se pudieron registrar todos los datos de la Reparto";
        }
        else {
        }
    break;
 
    case 'finalizar':
        $rspta=$reparto->finalizar($idreparto);
        echo $rspta ? "Reparto anulada" : "Reparto no se puede finalizar";
    break;

    case 'iniciar':
        $rspta=$reparto->iniciar($idreparto);
        echo $rspta ? "Reparto iniciado" : "Reparto no se puede iniciar";
    break;
 
    case 'mostrar':
        $rspta=$reparto->mostrar($idreparto);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listarDetalle':
        //Recibimos el idcompra
        $id=$_GET['id'];
 
        $rspta = $reparto->listarDetalle($id);
        $total=0;
        echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>U. Medida</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<tr class="filas">
                    <td></td>
                    <td>'.$reg->nombre.'</td>
                    <td>'.$reg->cantidad.'</td>
                    <td>'.$reg->uMedida.'</td>
                    <td>'.$reg->precio_venta.'</td>
                    <td>'.$reg->descuento.'</td>
                    <td>'.$reg->subtotal.'</td></tr>';
                    $total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
                }
        echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                </tfoot>';
    break;
 
    case 'listar':
        $rspta=$reparto->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>(($reg->estado=='Iniciado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idreparto.')"><i class="fa fa-eye"></i></button>'.
                    ' <button class="btn btn-danger" onclick="finalizar('.$reg->idreparto.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idreparto.')"><i class="fa fa-eye"></i></button>'.'<button class="btn btn-primary" onclick="iniciar('),
                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->repartidor,
                "4"=>$reg->total_venta,
                "5"=>($reg->estado=='Iniciado')?'<span class="label bg-green">Iniciado</span>':
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
 
    case 'selectCliente':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarC();
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
                }
    break;

    case 'selectRepartidor':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarR();
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
                }
    break;
 
    case 'listarProductosVenta':
        require_once "../modelos/Producto.php";
        $producto=new Producto();
 
        $rspta=$producto->listarActivosReparto();
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
}
?>