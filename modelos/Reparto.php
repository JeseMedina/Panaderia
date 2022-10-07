<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Reparto
{
    //Implementamos nuestro constructor
    public function __construct(){
 
    }

    //Implementamos un método para insertar registros
    public function insertar($idcliente,$idusuario,$idrepartidor,$fecha_hora,$idproducto,$cantidad,$precio_venta,$descuento){
        $sql="INSERT INTO reparto (idcliente,idusuario,idrepartidor,fecha_hora,estado) VALUES ('$idcliente','$idusuario','$idrepartidor','$fecha_hora','Iniciado')";
        //return ejecutarConsulta($sql);
        $idrepartonew=ejecutarConsulta_retornarID($sql);

        $num_elementos=0;
        $sw=True;
        echo '<script>console.log('.count($idproducto).'); </script>';

        while ($num_elementos < count($idproducto)){
            $sql_detalle = "INSERT INTO detalle_reparto(idreparto, idproducto,cantidad,precio_venta,descuento) VALUES ('$idrepartonew', '$idproducto[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }

    //Implementamos un método para anular el reparto
    public function finalizar($idreparto){
        $sql="UPDATE reparto SET estado='Finalizado' WHERE idreparto='$idreparto'";
        return ejecutarConsulta($sql);
    }

    public function iniciar($idreparto){
        $sql="UPDATE reparto SET estado='Iniciado' WHERE idreparto='$idreparto'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idreparto){
        $sql="SELECT r.idreparto,DATE(r.fecha_hora) as fecha,r.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,r.idrepartidor,p.nombre as repartidor,r.estado FROM reparto r INNER JOIN persona p ON r.idcliente=p.idpersona ON r.idrepartidor=p.idrepartidor INNER JOIN usuario u ON r.idusuario=u.idusuario WHERE r.idreparto='$idreparto'";//no se si "ON r.idrepartidor=p.idrepartidor" esta bien 
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listarDetalle($idreparto){
        $sql="SELECT dr.idreparto,dr.idproducto,p.nombre,dr.cantidad,p.uMedida,dr.precio_venta,dr.descuento,(dr.cantidad*dr.precio_venta-dr.descuento) as subtotal FROM detalle_reparto dr inner join producto p on dr.idproducto=p.idproducto where dr.idreparto='$idreparto'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT r.idreparto,DATE(r.fecha_hora) as fecha,r.idcliente,r.total_venta,p.nombre as cliente,u.idusuario,u.nombre as usuario,r.idrepartidor,pa.nombre as repartidor,r.estado FROM reparto r INNER JOIN persona p ON r.idcliente=p.idpersona INNER JOIN persona pa ON r.idrepartidor=pa.idpersona INNER JOIN usuario u ON r.idusuario=u.idusuario ORDER BY r.idreparto desc";//no se si "ON r.idrepartidor=p.idrepartidor" esta bien 
        return ejecutarConsulta($sql);      
    }
    
    // public function repartocabecera($idreparto)
    // {
    //     $sql="SELECT r.idreparto,r.idcliente,p.nombre as cliente, p.direccion,p.num_documento,p.email,p.telefono,r.idusuario,u.nombre as usuario, r.tipo_comprobante,r.serie_comprobante,r.num_comprobante,date(r.fecha_hora) as fecha,r.impuesto,r.total_venta FROM venta r INNER JOIN persona p on r.idcliente=p.idpersona INNER JOIN usuario u on r.idusuario=u.idusuario WHERE r.idreparto='$idreparto'";
        
    //     return ejecutarConsulta($sql);
    // }

    public function ventadetalle($idreparto)
    {
        $sql="SELECT p.nombre as producto,p.codigo,d.cantidad,d.precio_venta,d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal FROM detalle_reparto d INNER JOIN producto a on d.idproducto=p.idproducto WHERE d.idreparto='$idreparto'";
        return ejecutarConsulta($sql);
    }
}