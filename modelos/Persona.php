<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Persona
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($tipo_persona,$nombre,$num_documento,$provincia,$direccion,$telefono,$email)
    {
        $sql="INSERT INTO persona (tipo_persona,nombre,num_documento,provincia,direccion,telefono,email)
        VALUES ('$tipo_persona','$nombre','$num_documento','$provincia','$direccion','$telefono','$email')";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($idpersona,$tipo_persona,$nombre,$num_documento,$provincia,$direccion,$telefono,$email)
    {
        $sql="UPDATE persona SET tipo_persona='$tipo_persona',nombre='$nombre',num_documento='$num_documento',provincia='$provincia',direccion='$direccion',telefono='$telefono',email='$email' WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }
 
    /* //Implementamos un método para eliminar categorías
    public function eliminar($idpersona)
    {
        $sql="DELETE FROM persona WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    } */

    //Implementamos un método para desactivar registros
    public function desactivar($idpersona)
    {
        $sql="UPDATE persona SET condicion='0' WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para activar registros
    public function activar($idpersona)
    {
        $sql="UPDATE persona SET condicion='1' WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idpersona)
    {
        $sql="SELECT * FROM persona WHERE idpersona='$idpersona'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementar un método para listar los registros de persona
    public function listarp()
    {
        $sql="SELECT * FROM persona WHERE tipo_persona='Proveedor'";
        return ejecutarConsulta($sql);      
    }
 
    //Implementar un método para listar los registros de clientes 
    public function listarc()
    {
        $sql="SELECT * FROM persona WHERE tipo_persona='Cliente'";
        return ejecutarConsulta($sql);      
    }

    public function listarr()
    {
        $sql="SELECT * FROM persona WHERE tipo_persona='Repartidor'";
        return ejecutarConsulta($sql);      
    }

}
 
?>