<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Producto
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($idrubro,$codigo,$nombre,$stock,$uMedida,$precioCosto)
    {
        $sql="INSERT INTO producto (idrubro,codigo,nombre,stock,uMedida,precioCosto,condicion)
        VALUES ('$idrubro','$codigo','$nombre','$stock','$uMedida','$precioCosto','$precioVenta,'1')";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($idproducto,$idrubro,$codigo,$nombre,$stock,$uMedida,$precioCosto)
    {
        $sql="UPDATE producto SET idrubro='$idrubro',codigo='$codigo',nombre='$nombre',stock='$stock',uMedida='$uMedida',precioCosto='$precioCosto', precioVenta='$precioVenta WHERE idproducto='$idproducto'";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para desactivar registros
    public function desactivar($idproducto)
    {
        $sql="UPDATE producto SET condicion='0' WHERE idproducto='$idproducto'";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para activar registros
    public function activar($idproducto)
    {
        $sql="UPDATE producto SET condicion='1' WHERE idproducto='$idproducto'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idproducto)
    {
        $sql="SELECT * FROM producto WHERE idproducto='$idproducto'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT a.idproducto,a.idrubro,c.nombre as rubro,a.codigo,a.nombre,a.stock,a.uMedida,a.precioCosto,a.condicion FROM producto a INNER JOIN rubro c ON a.idrubro=c.idrubro";
        return ejecutarConsulta($sql);      
    }
 
    //Implementar un método para listar los registros activos
    public function listarActivos()
    {
        $sql="SELECT a.idproducto,a.idrubro,c.nombre as rubro,a.codigo,a.nombre,a.stock,a.uMedida,a.precioCosto,a.condicion FROM producto a INNER JOIN rubro c ON a.idrubro=c.idrubro WHERE a.condicion='1'";
        return ejecutarConsulta($sql);      
    }
 
    //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_compra)
    public function listarActivosVenta()
    {
        $sql="SELECT a.idproducto,a.idrubro,c.nombre as rubro,a.codigo,a.nombre,a.stock,(SELECT precio_venta FROM detalle_compra WHERE idproducto=a.idproducto order by iddetalle_compra desc limit 0,1) as precioVenta,a.uMedida,a.precioCosto,a.condicion FROM producto a INNER JOIN rubro c ON a.idrubro=c.idrubro WHERE a.condicion='1'";
        return ejecutarConsulta($sql);      
    }
}
 
?>