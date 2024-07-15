<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de Presentaciones de Embotellado</h1>
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
              <h3 class="card-title mb-0">Presentaciones registradas</h3>
              <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-categoria">Añadir Nueva presentacion</button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>

            </div>
            <div class="card-body">
              <table id="examplel" class="table table-bordered table-atriped">
                <thead>
                  <tr>
                    <th>
                      <center>Nro</center>
                    </th>
                    <th>
                      <center>Litraje del embotellado</center>
                    </th>
                    <th>
                      <center>Accion</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $contador = 0;
                  foreach ($data_presentacion as $dato_presentacion) {
                    $id_presentacion = $dato_presentacion['id_presentacion']; ?>

                    <tr>
                      <td><?php echo $contador = $contador + 1; ?></td>
                      <td><?php echo $dato_presentacion['litraje']; ?></td>
                      <td>
                        <button onclick="editar(<?=$dato_presentacion['id_presentacion'];?>)" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="eliminar(<?=$dato_presentacion['id_presentacion'];?>)" class="btn btn-danger btn-sm">
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

<!-- Modal crear Rol -->
<div class="modal fade" id="modal-add-categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Almacen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="litraje">Litraje</label>
            <input type="text" name="litraje" class="form-control" placeholder="Escriba aquí el litraje de la presentacion" required>
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

<!-- Modal editar categoria -->
<div class="modal fade" id="modal-edit-almacen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar presentacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="nombre_editar">litraje</label>
            <input type="text" name="nombre_editar" id="nombre_editar" class="form-control" placeholder="Escriba aquí el nombre del almacen" required>
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
<script src="public/js/presentacion.js"></script>