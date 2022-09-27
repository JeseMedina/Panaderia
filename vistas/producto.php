<?php
ob_start();
session_start();
 
if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
if ($_SESSION['almacen']==1)
{
?>
<!--Contenido-->
<head>
  <link rel="stylesheet"
          type="text/css"
          href="../public/css/general.css">
</head>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Productos <button class="btn btn-success"
                                id="btnagregar"
                                onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>
                                Agregar</button> <a target="_blank"
                                href="../reportes/rptproductos.php"><button
                                    class="btn btn-info">Reporte</button></a> </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="panel-body table-responsive"
                        id="listadoregistros">
                        <table id="tbllistado"
                            class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Rubro</th>
                                <th>Stock</th>
                                <th>U. Medida</th>
                                <th>Precio Costo</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Rubro</th>
                                <th>Stock</th>
                                <th>U. Medida</th>
                                <th>Precio Costo</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body"
                        id="formularioregistros">
                        <form name="formulario"
                            id="formulario"
                            method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Nombre(*):</label>
                                <input type="hidden"
                                    name="idproducto"
                                    id="idproducto">
                                <input type="text"
                                    class="form-control"
                                    name="nombre"
                                    id="nombre"
                                    maxlength="100"
                                    placeholder="Nombre"
                                    required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Categoría(*):</label>
                                <select id="idrubro"
                                    name="idrubro"
                                    class="form-control selectpicker"
                                    data-live-search="true"
                                    required></select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Stock(*):</label>
                                <input type="number"
                                    class="form-control"
                                    name="stock"
                                    id="stock"
                                    required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Unidad de Medida:</label>
                                <select class="form-control"
                                    name="uMedida"
                                    id="uMedida">
                                    <option value="Gramo">Gramo</option>
                                    <option value="Kilogramo">Kilogramo</option>
                                    <option value="Miligramo">Miligramo</option>
                                    <option value="Litro">Litro</option>
                                    <option value="Unidad">Unidad</option>
                                    <option value="Docena">Docena</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Precio de Costo:</label>
                                <input type="text"
                                    class="form-control"
                                    name="precioCosto"
                                    id="precioCosto">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Código:</label>
                                <input type="text"
                                    class="form-control"
                                    name="codigo"
                                    id="codigo"
                                    placeholder="Código Barras">
                                <button class="btn btn-success"
                                    type="button"
                                    onclick="generarbarcode()">Generar</button>
                                <button class="btn btn-info"
                                    type="button"
                                    onclick="imprimir()">Imprimir</button>
                                <div id="print">
                                    <svg id="barcode"></svg>
                                </div>
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
                </div>
            </div>
        </div>
    </section>
</div>
<?php
}
else
{
  require 'noacceso.html';
}
require 'footer.html';
?>
<script type="text/javascript"
    src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript"
    src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript"
    src="scripts/producto.js"></script>
<?php 
}
ob_end_flush();
?>