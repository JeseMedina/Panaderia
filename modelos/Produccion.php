<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Produccion{
    //Implementamos nuestro constructor
    public function __construct(){
 
    }

    public function insertar($idpanadero,$idproducto,$fecha_hora,$idmateria,$cantidad){
        $sql="INSERT INTO produccion (idpanadero,idproducto,cantidadProducida,fecha_hora,precio_venta,estado) VALUES ('$idpanadero','$idproducto','0','$fecha_hora','0','Iniciado')";
        $idproduccionnew=ejecutarConsulta_retornarID($sql);

        $num_elementos=0;
        $sw=True;

        while ($num_elementos < count($idmateria)){
            $sql_detalle = "INSERT INTO detalle_produccion(idproduccion, idmateria,cantidad)VALUES ('$idproduccionnew', '$idmateria[$num_elementos]','$cantidad[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }

    //Implementamos un método para anular el produccion
    public function finalizar($idproduccion,$cantidadProducida,$precio_venta){
        $sql="UPDATE produccion SET estado='Finalizado',cantidadProducida='$cantidadProducida',precio_venta='$precio_venta' WHERE idproduccion='$idproduccion'";
        return ejecutarConsulta($sql);
    }

    public function iniciar($idproduccion){
        $sql="UPDATE produccion SET estado='Iniciado' WHERE idproduccion='$idproduccion'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idproduccion){
        $sql="SELECT r.idproduccion,DATE(r.fecha_hora) as fecha,r.idpanadero,p.nombre as panadero,r.estado,r.idproducto,a.nombre as producto,r.cantidadProducida,a.uMedida,r.precio_venta FROM produccion r INNER JOIN persona p ON r.idpanadero=p.idpersona INNER JOIN producto a ON r.idproducto=a.idproducto WHERE r.idproduccion='$idproduccion'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listarDetalle($idproduccion){
        $sql="SELECT dp.idproduccion,dp.idproducto,p.nombre,dp.cantidad,p.uMedida FROM detalle_produccion dp inner join producto p on dp.idproducto=p.idproducto where dp.idproduccion='$idproduccion'";
        return ejecutarConsulta($sql);
    }

    public function listar()
    {
        $sql="SELECT r.idproduccion,DATE(r.fecha_hora) as fecha,r.idpanadero,p.nombre as panadero,r.estado,r.idproducto,a.nombre,r.cantidadProducida,a.uMedida,r.precio_venta FROM produccion r INNER JOIN persona p ON r.idpanadero=p.idpersona INNER JOIN producto a ON r.idproducto=a.idproducto ORDER BY r.idproduccion desc";
        return ejecutarConsulta($sql);      
    }

    // public function ventadetalle($idreparto)
    // {
    //     $sql="SELECT p.nombre as producto,p.codigo,d.cantidad,d.precio_venta,d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal FROM detalle_reparto d INNER JOIN producto a on d.idproducto=p.idproducto WHERE d.idreparto='$idreparto'";
    //     return ejecutarConsulta($sql);
    // }
}