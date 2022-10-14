<?php
if (strlen(session_id()) < 1) 
{
  session_start();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <title>Panaderia Eben Ezer</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport">
    <link rel="stylesheet"
        href="../public/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="../public/css/font-awesome.css">
    <link rel="stylesheet"
        href="../public/css/AdminLTE.min.css">
    <link rel="stylesheet"
        href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon"
        href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon"
        href="../public/img/favicon.ico">
    <link rel="stylesheet"
        type="text/css"
        href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet"
        type="text/css"
        href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet"
        type="text/css"
        href="../public/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet"
        type="text/css"
        href="../public/css/bootstrap-select.min.css">
    <link rel="stylesheet"
        type="text/css"
        href="../public/css/header.css">
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="escritorio.php"
                class="logo">
                <span class="logo-mini"><b>ARMECA</b></span>
                <span class="logo-lg"><b>ARMECA</b></span>
            </a>

            <nav class="navbar navbar-static-top"
                role="navigation">
                <a href="#"
                    class="sidebar-toggle"
                    data-toggle="offcanvas"
                    role="button">
                    <span class="sr-only">Navegación</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#"
                                class="dropdown-toggle"
                                data-toggle="dropdown">
                                <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>"
                                    class="user-image"
                                    alt="User Image">
                                <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>"
                                        class="img-circle"
                                        alt="User Image">
                                    <p>
                                        <?php echo $_SESSION['nombre']; ?>
                                        <!-- <?php echo $_SESSION['cargo']; ?> -->
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="../controlador/usuario.php?op=salir"
                                            class="btn btn-default btn-flat">Cerrar Sesión</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu">
                    <li class="header"></li>
                    <?php
            if ($_SESSION['escritorio']==1) 
            {
              echo '<li>
              <a href="escritorio.php">
                <i class="fa fa-laptop"></i> <span>Escritorio</span>
              </a>
            </li>';
            }  
            ?>
                    <?php
            if ($_SESSION['almacen']==1) 
            {
              echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Almacén</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="producto.php"> Productos</a></li>
                <li><a href="rubro.php"> Rubros</a></li>
              </ul>
            </li>';
            }  
            ?>
                    <?php
            if ($_SESSION['compras']==1) 
            {
              echo '<li class="treeview">
              <a href="compra.php">
                <i class="fa fa-cart-arrow-down"></i>
                <span>Compras</span>
              </a>
            </li>';
            }  
            ?>
                    <?php
            if ($_SESSION['ventas']==1) 
            {
              echo '<li class="treeview">
              <a href="venta.php">
                <i class="fa fa-shopping-cart"></i>
                <span>Ventas</span>
              </a>
            </li> ';
            }  
            ?>

                    <?php
            if ($_SESSION['reparto']==1) 
            {
              echo '<li class="treeview">
              <a href="reparto.php">
                <i class="fa fa-truck"></i> <span>Reparto</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="reparto.php"> Iniciar Reparto</a></li>
                <li><a href="finalizarreparto.php"> Finalizar Reparto</a></li>      
              </ul>
            </li>';
            } 
            ?>

            <?php
            if ($_SESSION['produccion']==1) 
            {
              echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-industry"></i> <span>Produccion</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="produccion.php"> Iniciar Produccion</a></li>
                <li><a href="finalizarproduccion.php"> Finalizar Produccion</a></li>
                
              </ul>
            </li>';
            } 
            ?>
            <?php
            if ($_SESSION['personas']==1) 
            {
              echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Personas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="cliente.php"> Clientes</a></li>
                <li><a href="proveedor.php"> Proveedores</a></li>
                <li><a href="repartidor.php"> Repartidores</a></li>
                <li><a href="panadero.php"> Panaderos</a></li>
                <li><a href="usuario.php"> Usuarios</a></li>
                <li><a href="permiso.php"> Permisos</a></li>
              </ul>
            </li>';
            }
            ?>
                    <?php
            if ($_SESSION['consulta']==1) 
            {
              echo ' <li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Consultas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="ventasfechacliente.php"> Consulta Ventas</a></li>
                <li><a href="comprasfecha.php"> Consulta Compras</a></li>               
              </ul>
            </li>
            <li>';
            }  
            ?>
                    <a href="#">
                        <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                        <small id="pdf" class="label pull-right">PDF</small>
                    </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                            <small id="mantovani" class="label pull-right">IT - Mantovani</small>
                        </a>
                    </li>

                </ul>
            </section>
        </aside>