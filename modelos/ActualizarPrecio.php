<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ActualizarPrecio{

    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    public function editar($idproducto,$nuevoprecio)
    {
        $sql="UPDATE detalle_compra SET precio_venta_nuevo='$nuevoprecio' WHERE idproducto='$idproducto' order by iddetalle_compra desc LIMIT 1";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idproducto)
    {
        $sql="SELECT detalle_compra.idproducto, producto.nombre,ifnull(detalle_compra.precio_venta_nuevo ,detalle_compra.precio_venta) as precioVenta FROM producto,detalle_compra WHERE detalle_compra.idproducto='$idproducto' AND producto.idproducto = detalle_compra.idproducto order by iddetalle_compra desc limit 1";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar()
    {
        $sql="SELECT d.idproducto,p.nombre,ifnull(max(d.precio_venta_nuevo) ,max(d.precio_venta)) as precio_actual from detalle_compra d, producto p where d.idproducto = p.idproducto GROUP by d.idproducto ORDER BY p.nombre";
        return ejecutarConsulta($sql);      
    }



}

?>