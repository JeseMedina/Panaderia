<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 
if (!isset($_SESSION["compras"]))
{
  header("Location: noacceso.html");
}
else
{ 
require 'header.php';
 
if ($_SESSION['compras']==1)
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
                        <h1 class="box-title">Compras</h1>
                        <div class="boton-agregar">
                            <button
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Agregar Compras"
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
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Comprobante</th>
                                <th>Total Compra</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Comprobante</th>
                                <th>Total Compra</th>
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
                            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label>Proveedor(*):</label>
                                <input type="hidden"
                                    name="idcompra"
                                    id="idcompra">
                                <select id="idproveedor"
                                    name="idproveedor"
                                    class="form-control selectpicker"
                                    data-live-search="true"
                                    required>

                                </select>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Fecha(*):</label>
                                <input type="date"
                                    class="form-control"
                                    name="fecha_hora"
                                    id="fecha_hora"
                                    required="">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Tipo Comprobante(*):</label>
                                <select name="tipo_comprobante"
                                    id="tipo_comprobante"
                                    class="form-control selectpicker"
                                    required="">
                                    <option value="Boleta">Boleta</option>
                                    <option value="Factura">Factura</option>
                                    <option value="Ticket">Ticket</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Serie:</label>
                                <input type="text"
                                    class="form-control"
                                    name="serie_comprobante"
                                    id="serie_comprobante"
                                    maxlength="7"
                                    placeholder="Serie">
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Número:</label>
                                <input type="text"
                                    class="form-control"
                                    name="num_comprobante"
                                    id="num_comprobante"
                                    maxlength="10"
                                    placeholder="Número"
                                    required="">
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Impuesto:</label>
                                <input type="text"
                                    class="form-control"
                                    name="impuesto"
                                    id="impuesto"
                                    required="">
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a data-toggle="modal"
                                    href="#myModal">
                                    <button
                                        id="btnAgregarArt"
                                        type="button"
                                        class="btn btn-primary">
                                        Agregar productos
                                    </button>
                                </a>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <table id="detalles"
                                    class="table table-striped table-bordered table-condensed table-hover">
                                    <thead style="background-color:#A9D0F5">
                                        <th>Opciones</th>
                                        <th>producto</th>
                                        <th>Cantidad</th>
                                        <th>U. Medida</th>
                                        <th>Precio Compra</th>
                                        <th>Precio Venta</th>
                                        <th>Subtotal</th>
                                    </thead>
                                    <tfoot>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <h4 id="total">$ 0.00</h4><input type="hidden"
                                                name="total_compra"
                                                id="total_compra">
                                        </th>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Guardar Compra"
                                    class="btn btn-primary"
                                    type="submit"
                                    id="btnGuardar">Guardar
                                </button>

                                <button
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Cancelar y volver atrás"
                                    id="btnCancelar"
                                    class="btn btn-danger"
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
                <button title="Seleccionar Productos"
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
                        <th>Rubro</th>
                        <th>Stock</th>
                        <th>U. Medida</th>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Rubro</th>
                        <th>Stock</th>
                        <th>U. Medida</th>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button title="Cerrar Ventana"
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php
}
else
{
    header("Location: venta.php");
}
  require 'footer.html';
}
?>
<script type="text/javascript"
    src="scripts/compra.js"></script>