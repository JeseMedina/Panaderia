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
                        <div class="box-tools pull-right"></div>
                    </div>
                    <div class="panel-body"
                        style="height: 400px;"
                        id="formularioretiro">
                        <form name="formulario"
                            id="formulario"
                            method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Dinero a Retirar(*):</label>
                                <input type="hidden"
                                    name="idcaja"
                                    id="idcaja">
                                <input type="number"
                                    class="form-control"
                                    name="retiro"
                                    id="retiro"
                                    placeholder="Dinero a Retirar">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Dinero Disponible:</label>
                                <input type="number"
                                    class="form-control"
                                    name="total"
                                    id="total"
                                    placeholder="Dinero Disponible"
                                    readonly>
                            </div>

                            <div class="form-group botones col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button data-toggle="tooltip" 
                                    title="Retirar Dinero"
                                    data-placement="bottom"
                                    class="btn btn-danger cancelar"
                                    type="submit"
                                    id="btnRetirar">
                                    Retirar
                                </button>
                            </div>
                        </form>
                    </div>
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
    src="scripts/cajaretirar.js"></script>
<?php 
}
ob_end_flush();
?>