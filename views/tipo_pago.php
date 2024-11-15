<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de Tipos de Pagos</h1>
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
              <h3 class="card-title mb-0">Tipos de Pagos registrados</h3>
              <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-tipo-pago">Añadir Tipo de Pago</button>
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

<!-- Modal crear tipo de pago -->
<div class="modal fade" id="modal-add-tipo-pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo tipo de pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="nombre_tipo">Nombre del Tipo de Pago <span class="required">*</span></label>
            <input type="text" name="nombre" id="nombre_tipo" class="form-control" placeholder="Escriba aquí el nombre del tipo de pago" >
            <span id="nombre_tipoError" class="text-danger"></span>
          </div>
        </div>
  
        <div class="modal-footer">
        <a href="" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary" disabled id="registrar">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal editar marca -->
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
            <label for="nombre_editar">Nombre del Nuevo Metodo de Pago <span class="required">*</span></label>
            <input type="text" name="nombre_editar" id="nombre_editar" class="form-control" placeholder="Escriba aquí el nombre de la categoria" required>
            <span id="nombre_editarError" class="text-danger"></span>
          </div>
        </div>
        <div class="modal-footer">
        <a href="" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary" id="modificar">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
        
<?php include('views/layout/footer.php'); ?>
<script src="public/js/tipo_pago.js"></script>