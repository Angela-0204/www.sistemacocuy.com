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

                  <a href="?pagina=usuario_create">
                  <button type="submit" class="btn btn-primary ml-3">Añadir Usuario</button>
                  </a>

                </div>
                <div class="ml-auto">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>

              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <tr>
                    <th>Nro</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                  </tr>
                    <tbody>
                      <?php
                        foreach ($data_users as $data_user) { ?>
                          <tr>
                            <td><?php echo $data_user['id_users']?></td>
                            <td><?php echo $data_user['names']?></td>
                            <td><?php echo $data_user['email']?></td>
                            <td><?php echo $data_user['id_rol']?></td>
            
                            <td>
                              <a href="editar_usuario.php?id=<?php echo $data_user['id_users']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a href="eliminar_usuario.php?id=<?php echo $data_user['id_users']; ?>" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                          </tr>
                      <?php
                        }
                      ?>
                    </tbody>
                </table>
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