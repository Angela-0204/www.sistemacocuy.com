<?php include('views/layout/menu.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Listado de usuario</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
      <div class="row">
          <div class="col-md-8">
            <div class="card card-outline card-primary">
              <div class="card-header d-flex align-items-center">
                <div class="d-flex align-items-center">
                  <h3 class="card-title mb-0">Usuarios registrados</h3>
                  <button type="submit" class="btn btn-primary ml-3">Añadir Usuario</button>
                </div>
                <div class="ml-auto">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>

              <div class="card-body">
              <div class="row">
                  <div class="col-md-12">
                    <form action="../app/controllers/usuarios/create.php" method="post">

                      <div class="form-group">
                        <label for="">Nombres</label>
                        <input type="text" name="names" class="form-control" placeholder="Escriba aquí el nombre del Nuevo Usuario">
                      </div>

                      <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Escriba aquí el Email del Nuevo Usuario">
                      </div>

                      <div class="form-group">
                        <label for="">Contraseña</label>
                        <input type="text" name="password_user" class="form-control">
                      </div>

                      <div class="form-group">
                        <label for="">Repita Contraseña</label>
                        <input type="text" name="password_repeat" class="form-control">
                      </div>
                      <hr>
                      <div class="form-group">
                        <a href="" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                      </div>

                    </form>
                  </div>
                </div>
              </div>

              </div>

            </div>
          </div>
        </div>

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('views/layout/footer.php'); ?>