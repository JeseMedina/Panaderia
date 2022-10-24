<?php
require "../config/Conexion.php";

Class Caja{
    
    public function __contruct(){

    }

    public function insertar($fecha_hora,$inicio){
        $sql="INSERT INTO caja (fecha_hora,inicio,ingreso,egreso,total,estado) VALUES ('$fecha_hora','$inicio','0','0','0','Abierta')";
        return ejecutarConsulta($sql);
    }

    public function cerrarCaja($idcaja){
        $sql="UPDATE caja SET estado='Cerrada' WHERE idcaja='$idcaja'";
        return ejecutarConsulta($sql);
    }

    public function listar(){
        $sql="SELECT idcaja,DATE(fecha_hora) as fecha,inicio,ingreso,egreso,total,estado FROM caja ORDER BY idcaja DESC";
        return ejecutarConsulta($sql);
    }

    public function cajaAbierta(){
        $sql="SELECT idcaja FROM caja WHERE estado='Abierta'";
        return ejecutarConsulta($sql);
    }
}
?>