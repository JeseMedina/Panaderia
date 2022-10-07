<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Produccion{
    //Implementamos nuestro constructor
    public function __construct(){
 
    }

    public function insertar($idpanadero,$idproducto,$cantidadProducida,$fecha_hora,$idmateria,$cantidad,$precio_venta){
        $sql="INSERT INTO produccion (idpanadero,idproducto,cantidadProducida,fecha_hora,precio_venta,estado) VALUES ('$idpanadero','$idproducto','$cantidadProducida','$fecha_hora','$precio_venta','Iniciado')";
        //return ejecutarConsulta($sql);
        $idproduccionnew=ejecutarConsulta_retornarID($sql);

        $num_elementos=0;
        $sw=True;

        while ($num_elementos < count($idproducto)){
            $sql_detalle = "INSERT INTO detalle_produccion(idproduccion, idmateria,cantidad)VALUES ('$idproduccionnew', '$idmateria[$num_elementos]','$cantidad[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }

    //Implementamos un método para anular comprass
    public function anular($idproduccion)
    {
        $sql="UPDATE produccion SET estado='Anulado' WHERE idproduccion='$idproduccion'";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idcompra)
    {
        $sql="SELECT i.idcompra,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM compra i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idcompra='$idcompra'";
        return ejecutarConsultaSimpleFila($sql);
    }
}