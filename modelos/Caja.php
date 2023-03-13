<?php
require "../config/Conexion.php";

Class Caja{
    
    public function __contruct(){

    }

    public function insertar($fecha_hora,$inicio){
        $sql="INSERT INTO caja (fecha_hora,inicio,ingreso,egreso,total,estado) VALUES ('$fecha_hora','$inicio','0','0','0','Abierta')";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idcaja){
        $sql="SELECT idcaja,ingreso FROM caja WHERE idcaja='$idcaja'";
        return ejecutarConsultaSimpleFila($sql);
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

    public function listarCajaId(){
        $sql = "SELECT * FROM caja WHERE estado='Abierta'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function retirarEfectivo($idcaja,$retiro){
        $sql="INSERT INTO caja_retiro (idcaja,retiro) VALUES ('$idcaja','$retiro')";
        return ejecutarConsulta($sql);
    }

    public function reabrirCaja($idcaja){
        $sql="UPDATE caja SET estado='Abierta' Where idcaja='$idcaja'";
        return ejecutarConsulta($sql);
    }
}
?>