<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de Bancos</h1>
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
              <h3 class="card-title mb-0">Bancos registradas</h3>
              <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-categoria">Añadir Banco</button>
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
                      <center>Nombre del Banco</center>
                    </th>
                    <th>
                      <center>Datos del Banco</center>
                    </th>
                    <th>
                      <center>Tipo de Pago</center>
                    </th>
                    <th>
                      <center>Accion</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $contador = 0;
                  foreach ($data_banco as $banco_dato) {
                    $id_tipo_pago = $banco_dato ['id_tipo_pago'];
                    $id_banco = $banco_dato['id_banco']; ?>

                    <tr>
                      <td><?php echo $contador = $contador + 1; ?></td>
                     
                      <td><?php echo $banco_dato['nombre_banco']; ?></td>
                      <td><?php echo $banco_dato['datos_banco']; ?></td>
                      <td><?php echo $banco_dato['nombre']; ?></td>
                      
                      <td>
                        <button onclick="editar(<?=$banco_dato['id_banco'];?>)" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="eliminar(<?=$banco_dato['id_banco'];?>)" class="btn btn-danger btn-sm">
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

<!-- Modal crear banco -->
<div class="modal fade" id="modal-add-categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Banco</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="nombre_banco">Nombre del Banco <span class="required">*</span></label>
            <input type="text" maxlength="20" name="nombre_banco" id="nombre_banco" class="form-control" placeholder="Escriba aquí el nombre del Banco" required>
            <span id="nombre_bancoError" class="text-danger"></span>

          </div>
          <div class="form-group">
            <label for="nombre_banco">Datos del Banco  <span class="required">*</span></label>
            <input type="text" maxlength="25" name="datos_banco" id="datos_banco" class="form-control" placeholder="Escriba aquí los datos del Banco" required>
            <span id="datos_bancoError" class="text-danger"></span>

          </div>
         
          <div class="col align-self-center-md-4 form-group">
            <label for="">Metodo De Pago  <span class="required">*</span></label>
                <select name="tipo_pago" id="tipo_pago" class="form-control">
                      <?php foreach ($data_tipos as $pago_dato) { ?>
                            <option value="<?= $pago_dato['id_tipo_pago']; ?>"><?php echo $pago_dato['nombre']; ?></option>
                          <?php } ?>
                        </select>
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

<!-- Modal editar Banco-->
<div class="modal fade" id="modal-edit-categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Banco</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="nombre_editar">Nombre del Banco</label>
            <input type="text" maxlength="20" name="nombre_editar" id="nombre_editar" class="form-control" placeholder="Escriba aquí el nombre de la categoria" required>
          </div>
          <div class="form-group">
            <label for="">Datos del Banco</label>
            <input type="text" maxlength="25" name="datos_editar" id="datos_editar" class="form-control" placeholder="Escriba aquí el nombre de la categoria" required>
          </div>
          
          <div class="col align-self-center-md-4 form-group">
            <label for="">Metodo De Pago</label>
                <select name="tipo_pago_edit" id="tipo_pago_edit" class="form-control">
                      <?php foreach ($data_tipos as $pago_dato) { ?>
                            <option value="<?= $pago_dato['id_tipo_pago']; ?>"><?php echo $pago_dato['nombre']; ?></option>
                          <?php } ?>
                        </select>
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
<script src="public/js/banco.js"></script>