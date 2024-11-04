<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de Medidas (ml)</h1>
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
              <h3 class="card-title mb-0">Unidades de medidas (mL) registradas</h3>
              <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-categoria">Añadir nueva medida</button>
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
                      <center>Mililitros</center>
                    </th>
                    <th>
                      <center>Accion</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $contador = 0;
                  foreach ($data_medida as $medida_dato) {
                    $cod_unidad = $medida_dato['cod_unidad']; ?>

                    <tr>
                      <td><?php echo $contador = $contador + 1; ?></td>
                      <td><?php echo $medida_dato['medida']; ?></td>
                      
                      <td>
                        <button onclick="editar(<?=$medida_dato['cod_unidad'];?>)" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="eliminar(<?=$medida_dato['cod_unidad'];?>)" class="btn btn-danger btn-sm">
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

<!-- Modal crear medida -->
<div class="modal fade" id="modal-add-categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Medida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="nombre_medida">Cantidad en mL <span class="required">*</span></label>
            <input type="text" name="ml" class="form-control" id="nombre_medida" maxlength="30"  placeholder="Escriba aquí la cantidad en Mililitros ej(1000ml)">
            <span id="nombre_medidaError" class="text-danger"></span>
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
<div class="modal fade" id="modal-edit-categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Medida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="nombre_editar">Cantidad en mL</label>
            <input type="text" name="nombre_editar" id="nombre_editar" class="form-control" placeholder="Escriba aquí la cantidad en Mililitros ej(1000ml)" required>
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
<script src="public/js/medida.js"></script>