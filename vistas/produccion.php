<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 
if (!isset($_SESSION["produccion"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
 
if ($_SESSION['produccion']==1)
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
                        <h1 class="box-title">Iniciar Producción</h1> 
                        <div class="boton-agregar">
                            <button data-toggle="tooltip"
                                data-placement="bottom"
                                title="Nueva Producción"
                                class="btn btn-success"
                                id="btnagregar"
                                onclick="mostrarform(true)">
                                Agregar
                            </button>
                        </div>
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
                                <th>Nº</th>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>U. Medida</th>
                                <th>Cantidad</th>
                                <th>Precio Mayorista</th>
                                <th>Precio Minorista</th>
                                <th>Panadero</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nº</th>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>U. Medida</th>
                                <th>Cantidad</th>
                                <th>Precio Mayorista</th>
                                <th>Precio Minorista</th>
                                <th>Panadero</th>
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
                                <label>Panadero(*):</label>
                                <input type="hidden"
                                    name="idproduccion"
                                    id="idproduccion">
                                <select id="idpanadero"
                                    name="idpanadero"
                                    class="form-control selectpicker"
                                    data-live-search="true"
                                    required>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Producto(*):</label>
                                <select id="idproductoproducido"
                                    name="idproductoproducido"
                                    class="form-control selectpicker"
                                    data-live-search="true"
                                    required>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Fecha(*):</label>
                                <input type="date"
                                    class="form-control"
                                    name="fecha_hora"
                                    id="fecha_hora"
                                    required="">
                            </div>
                            <div id="divmostrar"
                                class="divmostrar">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-8">
                                    <label>Cantidad Producida(*):</label>
                                    <input type="text"
                                        class="form-control"
                                        name="cantidadproducida"
                                        id="cantidadproducida">
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                    <label>U. Medida(*):</label>
                                    <input type=""
                                        class="form-control"
                                        name="umedida"
                                        id="umedida">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Precio Mayorista(*):</label>
                                    <input type="number"
                                        class="form-control"
                                        name="preciomayorista"
                                        id="preciomayorista">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Precio Minorista(*):</label>
                                    <input type="number"
                                        class="form-control"
                                        name="preciominorista"
                                        id="preciominorista">
                                </div>
                            </div>
                            <div class="form-group agregar_producto col-lg-3 col-md-3 col-sm-6 col-xs-12 pt-3">
                                <a data-toggle="modal"
                                    href="#myModal">
                                    <button data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Agregar Materia Prima"
                                        id="btnAgregarArt"
                                        type="button"
                                        class="btn btn-primary">
                                        Agregar Productos
                                    </button>
                                </a>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <table id="detalles"
                                    class="table table-striped table-bordered table-condensed table-hover">
                                    <thead style="background-color:#A9D0F5">
                                        <th>Opciones</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>U. Medida</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group botones col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Guardar Producción"
                                    class="btn btn-primary guardar"
                                    type="submit"
                                    id="btnGuardar">Guardar
                                </button>

                                <button data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Cancelar y volver atrás"
                                    id="btnCancelar"
                                    class="btn btn-danger cancelar"
                                    onclick="cancelarform()"
                                    type="button">
                                    Cancelar
                                </button>
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

<!-- Modal -->
<div class="modal fade"
    id="myModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-toggle="tooltip"
                    data-placement="left"
                    title="Cerrar Ventana"
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-hidden="true">&times;
                </button>
                <h4 class="modal-title">Seleccione un Producto</h4>
            </div>
            <div class="modal-body">
                <table id="tblproductos"
                    class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>U. Medida</th>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>U. Medida</th>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button data-toggle="tooltip"
                    data-placement="left"
                    title="Cerrar Ventana"
                    type="button"
                    class="btn btn-default cerrar_modal"
                    data-dismiss="modal">Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal -->
<?php
}
else
{
    header("Location: cliente.php");
}
 
require 'footer.html';
?>
<script type="text/javascript"
    src="scripts/produccion.js"></script>
<script type="text/javascript" src="scripts/table_tooltips.js"></script>
<?php 
}
ob_end_flush();
?>