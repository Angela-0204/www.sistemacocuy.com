<?php include('views/layout/menu.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Listado de tipos de pago aprobados</h1>
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
                  <h3 class="card-title mb-0">Pagos registrados</h3>

                  <a href="?pagina=pago_create">
                  <button type="submit" class="btn btn-primary ml-3">Añadir Nuevo Tipo de Pago</button>
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
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Identificacion</th>
                    <th>Datos</th>
                  </tr>
                    <tbody>
                      <?php
                        foreach ($data_pagos as $data_pago) { ?>
                          <tr>
                            <td><?php echo $data_pago['id_tipo_pago']?></td>
                            <td><?php echo $data_pago['nombre']?></td>
                            <td><?php echo $data_pago['identificacion']?></td>
                            <td><?php echo $data_pago['datos']?></td>
            
                            <td>
                              <a href="editar_tipo.php?id=<?php echo $data_pago['id_tipo_pago']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a href="eliminar_tipo.php?id=<?php echo $data_pago['id_tipo_pago']; ?>" class="btn btn-danger btn-sm">
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