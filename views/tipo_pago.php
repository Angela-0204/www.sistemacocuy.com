<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de tipos de pagos</h1>
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
            <div class="card-header ">
              <h3 class="card-title mb-0">Metodos de pagos registrados</h3>
              <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-tipo-pago">Añadir Nuevo Metodo de pago</button>
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
                      <center>ID</center>
                    </th>
                    <th>
                      <center>Metodo de pago</center>
                 
                    <th>
                      <center>Accion</center>
                      
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $contador = 0;
                  foreach ($data_tipos as $data_tipo) {
                    $id_tipo_pago = $data_tipo['id_tipo_pago']; ?>

                    <tr>
                      <td><?php echo $contador = $contador + 1; ?></td>
                      <td><?php echo $data_tipo['nombre']; ?></td>
                
                      <td>
                        <button onclick="editar(<?=$data_tipo['id_tipo_pago'];?>)" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="eliminar(<?=$data_tipo['id_tipo_pago'];?>)" class="btn btn-danger btn-sm">
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

<!-- Modal agregar pago -->
<div class="modal fade" id="modal-add-tipo-pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Tipo de Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="cantidad">Nombre Del Metodo de Pago</label>
            <input type="text" name="nombre" class="form-control" placeholder="Escriba aquí el nuevo metodo de pago ejemplo (Transferencia, zelle, etc)" required>
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
        <h5 class="modal-title" id="exampleModalLabel">Editar Metodo de Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="nombre_editar">Nombre del Nuevo Metodo de Pago</label>
            <input type="text" name="nombre_editar" id="nombre_editar" class="form-control" placeholder="Escriba aquí el nombre de la categoria" required>
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
                </div>
<?php include('views/layout/footer.php'); ?>
<script src="public/js/tipo_pago.js"></script>