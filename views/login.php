<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Ventas</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="public/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="public/templeates/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="public/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">

  <!-- SweetAlert2 (para pestañas de alerta bonitas) -->
  <link rel="stylesheet" href="<?php echo $URL;?>/public/templeates/AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.min.css">


  <!-- Estilos personalizados -->
  <style>
    /* Estilo para los bordes rojos del formulario */
    .card-outline.card-primary {
      border-color: #ff0000; /* Color rojo para los bordes */
    }

    /* Estilo para el enlace "Sistema de Ventas" al pasar el cursor */
    .card-header a:hover {
      color: #ff0000; /* Color rojo al pasar el cursor */
    }
  </style>
</head>
<body class="hold-transition login-page" style="background: linear-gradient(135deg, #000000, #434343);">

<div class="login-box">
  <!-- /.login-logo -->
  <center>
    <img src="public/images/logococuy.png" alt="" width="200px">
  </center>
  <div class="card card-outline card-primary" style="background-color:#D3D3D3;">
    <div class="card-header text-center">
      <a href="public/templeates/AdminLTE-3.2.0/index2.html" class="h1"><b>Sistema de</b> <br>Ventas</a>
    </div>
    <div class="card-body" style="background-color:#D3D3D3;">
      <p class="login-box-msg">Ingresa tus datos para iniciar sesión NUEVO</p>

      <div class="input-group mb-3">
        <input type="email" name="email" id="email" class="form-control" placeholder="Correo">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="password" name="password_user" id="password_user" class="form-control" placeholder="Contraseña">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-8">
          <div class="icheck-primary">
            <input type="checkbox" id="remember">
            <label for="remember">
              Recuerdame
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-12">
          <button type="submit" id="entrar" class="btn btn-primary btn-block" style="background-color: #000000;">Ingresar</button>
        </div>
        <!-- /.col -->
      </div>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<br><br>

<!-- jQuery -->
<script src="public/templeates/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="public/templeates/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="public/templeates/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>

<!-- SweetAlert2 (para pestañas de alerta bonitas) -->
<script src="<?php echo $URL;?>/public/templeates/AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script src="public/js/login.js"></script>
</body>
</html>
