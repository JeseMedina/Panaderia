<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge" />
    <title>ARMECA</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport" />
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet"
        href="../public/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="../public/fontawesome/css/all.min.css">

    <!-- Theme style -->
    <link rel="stylesheet"
        href="../public/css/AdminLTE.css" />
    <!-- iCheck -->
    <link rel="stylesheet"
        href="../public/css/blue.css" />
    <!-- Login -->
    <link rel="stylesheet"
        href="../public/css/login.css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition login-page">
    <div class="img">
        <!-- <img src="../public/img/pan.jpg" alt=""> -->

        <div class="login-box">
        <div class="login-logo">
            <img class="medialuna" src="../public/img/medialuna.ico" alt="medialuna">
            <h1>ARMECA</h1>
          </div>
            <!-- /.login-logo -->
            <div class="login-box-body"
                id="divOlvido">
                <p class="login-box-msg">Ingrese sus datos para Recuperar su Contraseña</p>
                <form method="post"
                    id="frmOlvido">
                    <div class="form-group has-feedback">
                        <input type="text"
                            id="login"
                            name="login"
                            class="form-control"
                            placeholder="Usuario" />
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text"
                            id="dni"
                            name="dni"
                            class="form-control"
                            placeholder="DNI" />
                        <span class="fa fa-id-card form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="login.html">Volver al Login</a>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <button type="submit"
                                class="btn btn-primary btn-block btn-flat">
                                Recuperar Contraseña
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.login-box-body -->
            <div class="login-box-body"
                id="divCambiar">
                <p class="login-box-msg">Ingrese su Nueva Contraseña</p>
                <form method="post"
                    id="frmCambiar">
                    <div class="form-group has-feedback">
                        <input type="password"
                            id="clave1"
                            name="clave1"
                            class="form-control"
                            placeholder="Contraseña" />
                        <span class="fa fa-key form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password"
                            id="clave2"
                            name="clave2"
                            class="form-control"
                            placeholder="Repita la Contraseña" />
                        <span class="fa fa-key form-control-feedback"></span>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit"
                            class="btn btn-primary btn-block btn-flat">
                            Cambiar Contraseña
                        </button>
                    </div>

                </form>
            </div>
        </div>
        <!-- /.login-box -->
    </div>
</body>
<!-- jQuery 2.1.4 -->
<script src="../public/js/jquery-3.1.1.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../public/js/bootstrap.min.js"></script>
<!-- Bootbox -->
<script src="../public/js/bootbox.min.js"></script>
<script type="text/javascript"
    src="scripts/olvidemicontraseña.js"></script>

</html>