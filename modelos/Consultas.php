<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros
	public function comprasfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT DATE(i.fecha_hora) AS fecha,u.nombre AS usuario,p.nombre AS proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM compra i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND date(i.fecha_hora)<='$fecha_fin'";
		return ejecutarConsulta($sql);		
	}

	public function repartosfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT r.idreparto,DATE(r.fecha_hora) as fecha,r.idcliente,r.total_venta,p.nombre as cliente,u.idusuario,u.nombre as usuario,r.idrepartidor,pa.nombre as repartidor,r.estado FROM reparto r INNER JOIN persona p ON r.idcliente=p.idpersona INNER JOIN persona pa ON r.idrepartidor=pa.idpersona INNER JOIN usuario u ON r.idusuario=u.idusuario WHERE DATE(r.fecha_hora)>='$fecha_inicio' AND date(r.fecha_hora)<='$fecha_fin' AND r.estado='Finalizado'";
		return ejecutarConsulta($sql);		
	}

	public function produccionesfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT r.idproduccion,DATE(r.fecha_hora) as fecha,r.idpanadero,p.nombre AS panadero,r.idproductoproducido,a.nombre as producto,a.uMedida,r.cantidadproducida,r.preciomayorista,r.preciominorista,r.estado FROM produccion r INNER JOIN persona p ON r.idpanadero=p.idpersona INNER JOIN producto a ON r.idproductoproducido=a.idproducto WHERE DATE(r.fecha_hora)>='$fecha_inicio' AND date(r.fecha_hora)<='$fecha_fin' AND r.estado='Finalizado'";
		return ejecutarConsulta($sql);	
	}

	//Implementar un método para listar los registros
	public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
	{
		$sql="SELECT DATE(v.fecha_hora) AS fecha, u.nombre AS usuario,p.nombre AS cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin'AND v.idcliente='$idcliente'";
		return ejecutarConsulta($sql);		
	}
	public function totalcomprahoy()
	{
		$sql="SELECT IFNULL(SUM(total_compra),0) AS total_compra FROM compra WHERE DATE(fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}
	public function totalventahoy()
	{
		$sql="SELECT IFNULL(SUM(total_venta),0) AS total_venta FROM venta WHERE DATE(fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}
	public function comprasultimos_10dias()
    {
        $sql="SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) as fecha,SUM(total_compra) as total FROM compra GROUP by fecha_hora ORDER BY fecha_hora DESC limit 0,10";
        return ejecutarConsulta($sql);
    }
 
    public function ventasultimos_12meses()
    {
        $sql="SELECT DATE_FORMAT(fecha_hora,'%M') as fecha,SUM(total_venta) as total FROM venta GROUP by MONTH(fecha_hora) ORDER BY fecha_hora DESC limit 0,10";
        return ejecutarConsulta($sql);
    }
}

?>