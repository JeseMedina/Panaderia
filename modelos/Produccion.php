<?php
require "../config/Conexion.php";

Class Produccion{

    public function __construct(){

    }

    public function insertar($idpanadero,$idproductoproducido,$fecha_hora,$idproducto,$cantidad){
        $sql="INSERT INTO produccion (idpanadero,idproductoproducido,cantidadproducida,fecha_hora,preciomayorista,preciominorista,estado) VALUES ('$idpanadero','$idproductoproducido','0','$fecha_hora','0','0','Iniciado')";

        $idproduccionnew=ejecutarConsulta_retornarID($sql);

        $num_elementos=0;
        $sw=True;

        while ($num_elementos < count($idproducto)){
            $sql_detalle = "INSERT INTO 
            detalle_produccion(idproduccion,idproducto,cantidad)
            VALUES ('$idproduccionnew','$idproducto[$num_elementos]','$cantidad[$num_elementos]')";
            
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }

        return $sw;
    }

    public function finalizar($idproduccion,$cantidadproducida,$preciomayorista,$preciominorista){
        $sql="UPDATE produccion SET estado='Finalizado', cantidadproducida='$cantidadproducida', preciomayorista='$preciomayorista', preciominorista='$preciominorista' WHERE idproduccion='$idproduccion'";
        return ejecutarConsulta($sql);
    }
    


    public function mostrar($idproduccion){
        $sql="SELECT r.idproduccion,DATE(r.fecha_hora) as fecha,r.idpanadero,p.nombre AS panadero,r.idproductoproducido,a.nombre as producto,a.uMedida,r.cantidadproducida,r.preciomayorista,r.preciominorista,r.estado FROM produccion r INNER JOIN persona p ON r.idpanadero=p.idpersona INNER JOIN producto a ON r.idproductoproducido=a.idproducto WHERE r.idproduccion='$idproduccion'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listarDetalle($idproduccion){
        $sql="SELECT dr.idproduccion,dr.idproducto,p.nombre,dr.cantidad,p.uMedida FROM detalle_produccion dr INNER JOIN producto p ON dr.idproducto=p.idproducto WHERE dr.idproduccion='$idproduccion'";
        return ejecutarConsulta($sql);
    }

    public function listar(){
        $sql="SELECT r.idproduccion,DATE(r.fecha_hora) as fecha,r.idpanadero,p.nombre AS panadero,r.idproductoproducido,a.nombre as producto,a.uMedida,r.cantidadproducida,r.preciomayorista,r.preciominorista,r.estado FROM produccion r INNER JOIN persona p ON r.idpanadero=p.idpersona INNER JOIN producto a ON r.idproductoproducido=a.idproducto ORDER BY r.idproduccion DESC";
        return ejecutarConsulta($sql);
    }

    public function listarfinalizar(){
        $sql="SELECT r.idproduccion,DATE(r.fecha_hora) as fecha,r.idpanadero,p.nombre AS panadero,r.idproductoproducido,a.nombre as producto,a.uMedida,r.cantidadproducida,r.preciomayorista,r.preciominorista,r.estado FROM produccion r INNER JOIN persona p ON r.idpanadero=p.idpersona INNER JOIN producto a ON r.idproductoproducido=a.idproducto WHERE r.estado='Iniciado' ORDER BY r.idproduccion DESC";
        return ejecutarConsulta($sql);  
    }
}
?>