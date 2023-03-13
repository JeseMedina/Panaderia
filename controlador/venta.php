<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Venta.php";
 
$venta=new Venta();
 
$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_pago=isset($_POST["tipo_pago"])? limpiarCadena($_POST["tipo_pago"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
 
switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idventa)){
            $rspta=$venta->insertar($idcliente,$idusuario,$tipo_pago,$fecha_hora,$total_venta,$_POST["idproducto"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
            echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
        }
        else {
        }
    break;
 
    case 'anular':
        $rspta=$venta->anular($idventa);
        echo $rspta ? "Venta anulada" : "Venta no se puede anular";
    break;
 
    case 'mostrar':
        $rspta=$venta->mostrar($idventa);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listarDetalle':
        //Recibimos el idcompra
        $id=$_GET['id'];
 
        $rspta = $venta->listarDetalle($id);
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
                                    <th><h4 id="total">$'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                </tfoot>';
    break;
 
    case 'listar':
        $rspta=$venta->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>(($reg->estado=='Aceptado')?'<button data-toggle="tooltip" data-placement="right" title="Mostrar Venta" class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Anular Venta" class="btn btn-danger" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>':
                    '<button data-toggle="tooltip" data-placement="right" title="Mostrar Venta" class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'),
                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->usuario,
                "4"=>$reg->total_venta,
                "5"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
                '<span class="label bg-red">Anulado</span>'
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
 
    case 'listarProductosVenta':
        require_once "../modelos/Producto.php";
        $producto=new Producto();
 
        $rspta=$producto->listarActivosVenta();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button data-toggle="tooltip" data-placement="right" title="Agregar Producto" class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\',\''.$reg->uMedida.'\',\''.$reg->stock.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->rubro,
                "3"=>$reg->stock,
                "4"=>$reg->uMedida,
                "5"=>$reg->precio_venta
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