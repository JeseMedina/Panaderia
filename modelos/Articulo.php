<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Articulo
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($idcategoria,$codigo,$nombre,$stock,$uMedida,$precioCosto)
    {
        $sql="INSERT INTO articulo (idcategoria,codigo,nombre,stock,uMedida,precioCosto,condicion)
        VALUES ('$idcategoria','$codigo','$nombre','$stock','$uMedida','$precioCosto','1')";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$uMedida,$precioCosto)
    {
        $sql="UPDATE articulo SET idcategoria='$idcategoria',codigo='$codigo',nombre='$nombre',stock='$stock',uMedida='$uMedida',precioCosto='$precioCosto' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para desactivar registros
    public function desactivar($idarticulo)
    {
        $sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para activar registros
    public function activar($idarticulo)
    {
        $sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idarticulo)
    {
        $sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.uMedida,a.precioCosto,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";
        return ejecutarConsulta($sql);      
    }
 
    //Implementar un método para listar los registros activos
    public function listarActivos()
    {
        $sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.uMedida,a.precioCosto,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
        return ejecutarConsulta($sql);      
    }
 
    //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
    public function listarActivosVenta()
    {
        $sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta,a.uMedida,a.precioCosto,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
        return ejecutarConsulta($sql);      
    }
}
 
?>