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
    <title>ARMECA</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport">
    <link rel="stylesheet"
        href="../public/css/bootstrap.min.css">
    <!--     <link rel="stylesheet"
        href="../public/css/font-awesome.css"> -->
    <link rel="stylesheet"
        href="../public/fontawesome/css/all.min.css">
    <link rel="stylesheet"
        href="../public/css/AdminLTE.min.css">
    <link rel="stylesheet"
        href="../public/css/_all-skins.min.css">
    <link rel="medialuna"
        href="../public/img/medialuna.png">
    <link rel="shortcut icon"
        href="../public/img/medialuna.ico">
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
                <img class="logo-img"
                    src="../public/img/medialuna.png"
                    alt="medialuna"> ARMECA
            </a>

            <nav class="navbar navbar-static-top"
                role="navigation">
                <a href="#"
                    class="sidebar-toggle hidden-lg hidden-md hidden-sm"
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
                                <?php
                                if($_SESSION['imagen'] != ''){
                                ?>
                                <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>"
                                    class="user-image"
                                    alt="User Image">
                                <?php
                                }
                                ?>


                                <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <?php
                                    if($_SESSION['imagen'] != ''){
                                    ?>
                                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>"
                                        class="img-circle"
                                        alt="User Image">
                                    <?php
                                }
                                ?>
                                    <p>
                                        <?php echo $_SESSION['nombre']; ?>
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
            if ($_SESSION['caja']==1) 
            {
              echo '<li class="treeview">
              <a href="#">
              <i class="fa fa-sack-dollar"></i>
                <span>Caja</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="caja.php"> Caja</a></li>
                <li><a href="cajaretiro.php"> Retirar Efectivo</a></li>
              </ul>
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
                <i class="fa fa-industry"></i> <span>Producción</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="produccion.php"> Iniciar Producción</a></li>
                <li><a href="finalizarproduccion.php"> Finalizar Producción</a></li>
                
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
                <li><a href="ventasfechacliente.php">Ventas</a></li>
                <li><a href="comprasfecha.php">Compras</a></li>
                <li><a href="repartosfecha.php">Repartos</a></li>  
                <li><a href="produccionesfecha.php">Producciones</a></li>
              </ul>
            </li>';
            }  
            ?>
                    <li>
                        <a href="ayuda.html">
                            <i class="fa fa-info-circle"></i> <span>Ayuda</span>
                        </a>
                    </li>
                    <li>
                        <a href="developer.html">
                            <i class="fa-solid fa-laptop-code"></i></i> <span>Desarrolladores</span>
                            <!-- <small id="mantovani" class="label pull-right">IT - Mantovani</small> -->
                        </a>
                    </li>
                </ul>
            </section>
        </aside>