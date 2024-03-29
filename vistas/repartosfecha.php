<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["consulta"])) 
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['consulta']==1) 
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
                        <h1 class="box-title">Consulta de Repartos por Fecha</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive"
                        id="listadoregistros">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Inicio</label>
                            <input type="date"
                                class="form-control"
                                name="fecha_inicio"
                                id="fecha_inicio"
                                value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Fin</label>
                            <input type="date"
                                class="form-control"
                                name="fecha_fin"
                                id="fecha_fin"
                                value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <table id="tbllistado"
                            class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Fecha</th>
                                <th>Nº</th>
                                <th>Cliente</th>
                                <th>Repartidor</th>
                                <th>Total Venta</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Fecha</th>
                                <th>Nº</th>
                                <th>Cliente</th>
                                <th>Repartidor</th>
                                <th>Total Venta</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
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
  require 'noacceso.html';
}
require 'footer.html';
?>
<script type="text/javascript"
    src="scripts/repartosfecha.js"></script>
<?php 
}
ob_end_flush();
?>