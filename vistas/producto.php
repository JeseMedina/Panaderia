<?php
ob_start();
session_start();
 
if (!isset($_SESSION["almacen"]))
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
                        <h1 class="box-title">Productos</h1>
                            <div class="boton-agregar">
                                <button 
                                    class="btn btn-success"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Agregar Productos"
                                    id="btnagregar"
                                    onclick="mostrarform(true)">
                                    Agregar
                                </button>
                            </div>
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
                                    placeholder="Nombre del producto"
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
                                    placeholder="Stock del producto"
                                    required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Unidad de Medida:</label>
                                <div class="content-select">
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
                                    <i></i>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Código:</label>
                                <input type="text"
                                    class="form-control"
                                    name="codigo"
                                    id="codigo"
                                    onkeyup="generarbarcode()"
                                    placeholder="Ingrese aquí el Código de Barras">
                                <div class="contenedor_codigo_barra">
                                    <div id="print">
                                        <svg id="barcode"></svg>
                                    </div>
                                    <div class="btn-generar-imprimir">
                                        <!-- <button
                                            class="btn btn-success"
                                            type="button"
                                            onclick="generarbarcode()" 
                                            data-toggle="tooltip" 
                                            title="Generar código de barra"
                                            data-placement="bottom">Generar
                                        </button> -->
                                        <button
                                            class="btn btn-info"
                                            type="button"
                                            onclick="imprimir()"
                                            data-toggle="tooltip" 
                                            title="Imprimir código de barra"
                                            data-placement="bottom">Imprimir
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group botones col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button data-toggle="tooltip" 
                                    title="Guardar Producto"
                                    data-placement="bottom"
                                    class="btn btn-primary guardar"
                                    type="submit"
                                    id="btnGuardar">Guardar
                                </button>
                                <button data-toggle="tooltip" 
                                    title="Cancelar y volver atrás"
                                    data-placement="bottom"
                                    class="btn btn-danger cancelar"
                                    onclick="cancelarform()"
                                    type="button">Cancelar
                                </button>
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
    header("Location: compra.php");
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