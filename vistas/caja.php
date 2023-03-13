<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 
if (!isset($_SESSION["caja"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
 
if ($_SESSION['caja']==1)
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
                        <h1 class="box-title">Caja</h1>
                        <div class="boton-agregar">
                            <button data-toggle="tooltip"
                                data-placement="bottom"
                                title="Abrir Caja"
                                class="btn btn-success"
                                id="btnagregar"
                                onclick="mostrarform(true)">
                                Abrir Caja
                            </button>
                        </div>
                        <div class="box-tools pull-right"></div>
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
                                <th>Inicio</th>
                                <th>Ingreso</th>
                                <th>Egreso</th>
                                <th>Total</th>
                                <th>Estado</th>

                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Fecha</th>
                                <th>Inicio</th>
                                <th>Ingreso</th>
                                <th>Egreso</th>
                                <th>Total</th>
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
                                <label>Monto Inicial(*):</label>
                                <input type="hidden"
                                    name="idcaja"
                                    id="idcaja">
                                <input type="number"
                                    class="form-control"
                                    name="inicio"
                                    id="inicio">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Fecha(*):</label>
                                <input type="date"
                                    class="form-control"
                                    name="fecha_hora"
                                    id="fecha_hora"
                                    required=""
                                    value="<?php date('Y-m-d')?>">
                            </div>
                            <div class="form-group botones col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button data-toggle="tooltip" 
                                    title="Iniciar Caja"
                                    data-placement="bottom"
                                    class="btn btn-primary guardar"
                                    type="submit"
                                    id="btnGuardar">Abrir Caja
                                </button>

                                <button data-toggle="tooltip" 
                                    title="Cancelar y volver atrás"
                                    data-placement="bottom"
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

<?php
}
else
{
    header("Location: producto.php");
}

require 'footer.html';
?>
<script type="text/javascript"
    src="scripts/caja.js"></script>
<script type="text/javascript" src="scripts/table_tooltips.js"></script>
<?php 
}
ob_end_flush();
?>