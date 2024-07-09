<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de cajas</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-6">
          <div class="card card-outline card-primary">
            <div class="card-header ">
              <h3 class="card-title mb-0">Cajas registradas</h3>
              <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-caja">Añadir Cajas</button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>

            </div>
            <div class="card-body-md-6">
              <table id="examplel" class="table table-bordered table-atriped">
                <thead>
                  <tr>
                    <th>
                      <center>Nro</center>
                    </th>
                    <th>
                      <center>Cantidad de botellas</center>
                    </th>
                    <th>
                      <center>Descripción</center>
                    </th>
                    <th>
                      <center>Accion</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $contador = 0;
                  foreach ($data_cajas as $cajas_dato) {
                    $id_caja = $cajas_dato['id_caja']; ?>

                    <tr>
                      <td><?php echo $contador = $contador + 1; ?></td>
                      <td><?php echo $cajas_dato['cantidad']; ?></td>
                      <td><?php echo $cajas_dato['descripcion']; ?></td>
                      <td>
                        <button onclick="editar(<?=$cajas_dato['id_caja'];?>)" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="eliminar(<?=$cajas_dato['id_caja'];?>)" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  <?php
                  } ?>
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

<!-- Modal crear caja -->
<div class="modal fade" id="modal-add-caja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Caja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="cantidad">Cantidad de botellas</label>
            <input type="text" name="cantidad" class="form-control" placeholder="Escriba aquí la cantidad de botellas" required>
          </div>
          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" class="form-control" placeholder="Escriba aquí una descripción" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="registrar">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal editar caja -->
<div class="modal fade" id="modal-edit-caja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="cantidad_editar">Cantidad de botellas para la caja</label>
            <input type="text" name="cantidad_editar" id="cantidad_editar" class="form-control" placeholder="Escriba aquí el cantidad de botellas" required>
          </div>
          <div class="form-group">
            <label for="descripcion_editar">Descripción de caja</label>
            <input type="text" name="descripcion_editar" id="descripcion_editar" class="form-control" placeholder="Escriba aquí la descripción de la caja" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="modificar">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include('views/layout/footer.php'); ?>
<script src="public/js/caja.js"></script>