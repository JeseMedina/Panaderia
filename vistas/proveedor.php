<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 
if (!isset($_SESSION["personas"]))
{
  header("Location: login.html");
}
else
{ 
require 'header.php';
if ($_SESSION['personas']==1)
{ 
?>

<head>
    <link rel="stylesheet"
        type="text/css"
        href="../public/css/general.css">
</head>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Proveedor <button class="btn btn-success"
                                id="btnagregar"
                                onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>
                                Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive"
                        id="listadoregistros">
                        <table id="tbllistado"
                            class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Provincia</th>
                                <th>Direccion</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Provincia</th>
                                <th>Direccion</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body"
                        style="height: 400px;"
                        id="formularioregistros">
                        <form name="formulario"
                            id="formulario"
                            method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Nombre:</label>
                                <input type="hidden"
                                    name="idpersona"
                                    id="idpersona">
                                <input type="hidden"
                                    name="tipo_persona"
                                    id="tipo_persona"
                                    value="Proveedor">
                                <input type="text"
                                    class="form-control"
                                    name="nombre"
                                    id="nombre"
                                    maxlength="100"
                                    placeholder="Nombre del proveedor"
                                    required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Número Documento:</label>
                                <input type="text"
                                    class="form-control"
                                    name="num_documento"
                                    id="num_documento"
                                    maxlength="20"
                                    placeholder="Documento">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Provincia:</label>
                                <select class="form-control select-picker" id="provincia" name="provincia">
                                    <option value="Buenos Aires">Buenos Aires</option>
                                    <option value="Catamarca">Catamarca</option>
                                    <option value="Chaco" selected="true">Chaco</option>
                                    <option value="Chubut">Chubut</option>
                                    <option value="CABA">CABA</option>
                                    <option value="Cordoba">Cordoba</option>
                                    <option value="Corrientes">Corrientes</option>
                                    <option value="Entre Rios">Entre Rios</option>
                                    <option value="Formosa">Formosa</option>
                                    <option value="Jujuy">Jujuy</option>
                                    <option value="La Pampa">La Pampa</option>
                                    <option value="La Rioja">La Rioja</option>
                                    <option value="Mendoza">Mendoza</option>
                                    <option value="Misiones">Misiones</option>
                                    <option value="Neuquen">Neuquen</option>
                                    <option value="Rio Negro">Rio Negro</option>
                                    <option value="Salta">Salta</option>
                                    <option value="San Luis">San Luis</option>
                                    <option value="Santa Cruz">Santa Cruz</option>
                                    <option value="Santa Fe">Santa Fe</option>
                                    <option value="Santiago del Estero">Santiago del Estero</option>
                                    <option value="Tierra del Fuego">Tierra del Fuego</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Dirección:</label>
                                <input type="text"
                                    class="form-control"
                                    name="direccion"
                                    id="direccion"
                                    maxlength="70"
                                    placeholder="Dirección">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Teléfono:</label>
                                <input type="text"
                                    class="form-control"
                                    name="telefono"
                                    id="telefono"
                                    maxlength="20"
                                    placeholder="Teléfono">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Email:</label>
                                <input type="email"
                                    class="form-control"
                                    name="email"
                                    id="email"
                                    maxlength="50"
                                    placeholder="Email">
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary"
                                    type="submit"
                                    id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                                <button class="btn btn-danger"
                                    onclick="cancelarform()"
                                    type="button"><i class="fa fa-arrow-circle-left"></i>
                                    Cancelar</button>
                            </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
<?php
}
else
{
    header("Location: ventasfechacliente.php");
}
require 'footer.html';
}
?>
<script type="text/javascript" src="scripts/proveedor.js"></script>