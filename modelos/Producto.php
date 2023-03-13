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
    public function insertar($idrubro,$codigo,$nombre,$stock,$uMedida)
    {
        $sql="INSERT INTO producto (idrubro,codigo,nombre,stock,uMedida,condicion)
        VALUES ('$idrubro','$codigo','$nombre','$stock','$uMedida','1')";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($idproducto,$idrubro,$codigo,$nombre,$stock,$uMedida)
    {
        $sql="UPDATE producto SET idrubro='$idrubro',codigo='$codigo',nombre='$nombre',stock='$stock',uMedida='$uMedida' WHERE idproducto='$idproducto'";
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
        $sql="SELECT * FROM producto,detalle_compra WHERE producto.idproducto = detalle_compra.idproducto";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT a.idproducto,a.idrubro,c.nombre as rubro,a.codigo,a.nombre,a.stock,a.uMedida,a.condicion FROM producto a INNER JOIN rubro c ON a.idrubro=c.idrubro";
        return ejecutarConsulta($sql);      
    }
 
    //Implementar un método para listar los registros activos
    public function listarActivosCompra()
    {
        $sql="SELECT a.idproducto,a.idrubro,c.nombre as rubro,a.codigo,a.nombre,a.stock,a.uMedida,a.condicion FROM producto a INNER JOIN rubro c ON a.idrubro=c.idrubro WHERE a.condicion='1' AND c.nombre!='Panadería' AND c.nombre!='Confitería'";
        return ejecutarConsulta($sql);      
    }
 
    //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_compra)
    public function listarActivosVenta()
    {
        $sql="SELECT a.idproducto,a.idrubro,c.nombre as rubro,a.codigo,a.nombre,a.stock,IFNULL(iFNULL((SELECT precio_venta_nuevo FROM detalle_compra WHERE idproducto=a.idproducto order by iddetalle_compra desc limit 0,1),(SELECT precio_venta FROM detalle_compra WHERE idproducto=a.idproducto order by iddetalle_compra desc limit 0,1)),(SELECT preciominorista FROM produccion WHERE idproductoproducido=a.idproducto order by idproduccion desc limit 0,1)) as precio_venta ,a.uMedida,a.condicion FROM producto a INNER JOIN rubro c ON a.idrubro=c.idrubro WHERE a.condicion='1' AND c.nombre!='Materia Prima' order by nombre";
        return ejecutarConsulta($sql);      
    }

    public function listarActivosPanaderia()
    {
        $sql="SELECT a.idproducto,a.idrubro,c.nombre as rubro,a.codigo,a.nombre,a.stock,(SELECT preciomayorista FROM produccion WHERE idproductoproducido =a.idproducto order by idproduccion asc limit 0,1) as precio_venta,a.uMedida,a.condicion FROM producto a INNER JOIN rubro c ON a.idrubro=c.idrubro WHERE a.condicion='1' AND c.nombre='Panadería'";
        return ejecutarConsulta($sql);      
    }

    public function listarMateriaPrima()
    {
        $sql="SELECT a.idproducto,a.idrubro,c.nombre as rubro,a.codigo,a.nombre,a.stock,(SELECT precio_venta FROM detalle_compra WHERE idproducto=a.idproducto order by iddetalle_compra desc limit 0,1) as precio_venta,a.uMedida,a.condicion FROM producto a INNER JOIN rubro c ON a.idrubro=c.idrubro WHERE a.condicion='1' AND c.nombre='Materia Prima'";
        return ejecutarConsulta($sql);      
    }
}
 
?>