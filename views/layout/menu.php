<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Ventas</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo $URL;?>/public/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $URL;?>/public/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo $URL;?>/public/templeates/AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.min.css">

  <!-- SweetAlert2 (para pestañas de alerta bonitas) -->
  <script src="<?php echo $URL;?>/public/templeates/AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  

  <!-- Custom styles -->
  <style>
    body {
      background-color: black !important;
      color: black;
    }
    .navbar, .main-sidebar {
      background-color: #333 !important;
    }
    .navbar-light .navbar-nav .nav-link, .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link {
      color: white !important;
    }
    .brand-link, .brand-link .brand-text, .user-panel .info a {
      color: white !important;
    }
    .nav-sidebar>.nav-item>.nav-link.active {
      background-color: #444 !important;
      color: white !important;
    }
    .nav-sidebar>.nav-item>.nav-link {
      color: gray !important;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <!-- Rest of the HTML content -->

  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="?pagina=inicio" class="nav-link">Sistema de Ventas</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="?pagina=inicio" class="brand-link">
        <img src="<?php echo $URL;?>/public/images/logococuy.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">COCUY LEAL</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo $URL;?>/public/images/user.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION['sesion_email'];?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-solid fa-users"></i>
                <p>
                  Config de usuarios
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=usuario" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Listar de usuarios</p>
                  </a>
                </li>
                
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=roles" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lista de roles</p>
                  </a>
                </li>
              </ul>
            </li>
           
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>
                  Gestionar Producto
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=agregar_producto" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Agregar productos</p>
                  </a>
                  <a href="?pagina=inventario" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Consultar inventario</p>
                  </a>
                 
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tags"></i>
                <p>
                 Categorias
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=categoria" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Listar categorias</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-box"></i>
                <p>
                 Gestion de cajas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=caja" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Listado de cajas</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-wine-bottle"></i>
                <p>
                 Gestionar presentacion
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=presentacion" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Listado de presentaciones</p> 
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>
                 Gestion de pagos
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=tipo_pago" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Metodos de pago</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=banco" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bancos</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-clipboard"></i>
                <p>
                  Almacen
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=almacen" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Listado de almacen</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-truck"></i>
                <p>
                  Realizar Pedido
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?pagina=catalogo" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Realizar Pedido</p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item">
              <a href="?pagina=login" class="nav-link" style="background-color: #C82333">
                <i class="nav-icon fas fa-door-closed"></i>
                <p>
                  Cerrar Sesión
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
  </div>
</body>

</html>
