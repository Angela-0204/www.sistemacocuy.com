<?php include('views/layout/menu.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <?php if ($_SESSION['rol'] == 1) { ?>
              <h1 class="m-0">Bienvenido Administrador</h1>
            <?php } ?>
            <?php if ($_SESSION['rol'] == 2) { ?>
              <h1 class="m-0">Bienvenido Vendedor</h1>
            <?php } ?>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php if ($_SESSION['rol'] == 1) { ?>
        <div class="col-4 col-3">

          <div class="small-box bg-warning-col-md-8">
            <div class="inner">
              <h3>2</h3>
              <p>Usuarios Registrados</p>
            </div>
            <a href="?pagina=usuario">
              <div class="icon">
                <i class="nav-icon fas fa-user-plus"></i>
              </div>
            </a>
            <a href="?pagina=usuario" class="small-box-footer">Mas detalles <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>              
    <?php } ?>
    <!-- Main content -->


        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  
  <!-- /.content-wrapper -->
  <?php include('views/layout/footer.php'); ?>