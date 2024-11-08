<?php include('views/layout/menu_usuario.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Reportar Pago</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header ">
              <h3 class="card-title mb-0">Pagos registrados</h3>
              <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="pagoModalLabel">Registrar Pago de Pedido</button>
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
                      <center>Nro De Pago</center>
                    </th>
                
                    <th>
                      <center>Tipo de Pago Efectuado</center>
                    </th>
                    <th>
                      <center>Banco Receptor</center>
                    </th>
                   
                       <th>
                      <center>Monto Depositado</center>
                    </th>
                    
                    <th>
                      <center>Numero de pedido</center>
                    </th>
                    <th>
                      <center>Cliente</center>
                    </th>
                    <th>
                      <center>Vendedor</center>
                    </th>
                
                    <th>
                      <center>Accion</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $contador = 0;
                  foreach ($data_reportes as $pago_dato) {
                    $nro_pago = $pago_dato['nro_pago']; ?>

                    <tr>
                      <td><?php echo $contador = $contador + 1; ?></td>
                      
                      <td><?php echo $pago_dato['tipo_pago']; ?></td>
                      <td><?php echo $pago_dato['nombre_banco']; ?></td>
                      <td><?php echo $pago_dato['monto']; ?></td>
                      <td><?php echo $pago_dato['id_pedido']; ?></td>
                      <td><?php echo $pago_dato['nombre_cliente']; ?></td>
                      <td><?php echo $pago_dato['usuario']; ?></td>

                      <td>
                        <button onclick="editar(<?=$pago_dato['nro_pago'];?>)" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="eliminar(<?=$pago_dato['nro_pago'];?>)" class="btn btn-danger btn-sm">
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
<!-- Modal Structure -->
<div class="modal fade" id="pagoModal" tabindex="-1" aria-labelledby="pagoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pagoModalLabel">Registrar Pago de Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="nombre">Seleccione el método de pago utilizado</label>
            <select name="nombre" id="nombre" class="form-control">
              <?php foreach ($data_tipos as $tipos) { ?>
                <option value="<?= $tipos['id_tipo_pago']; ?>"><?php echo $tipos['nombre']; ?></option>
              <?php } ?>
            </select>  
          </div>

          <div class="form-group">
            <label for="pedido">Seleccione el pedido al cual va a realizar el pago</label>
            <select name="nombre" id="nombre" class="form-control">
              <?php foreach ($pedido as $data_pedidos) { ?>
                <option value="<?= $tipos['id_pedido']; ?>"><?php echo $tipos['id_pedido']; ?></option>
              <?php } ?>
            </select>  
          </div>
          
          <div class="form-group">
            <label for="referencia">Número de Referencia</label>
            <input type="text" name="referencia" class="form-control" placeholder="Escriba aquí el número de referencia del depósito">
          </div>
          
     
          
          <div class="form-group">
            <label for="monto">Monto depositado en Bolívares</label>
            <input type="number" name="monto" class="form-control" placeholder="Escriba aquí la cantidad depositada en bolívares">
          </div>
          
          <div class="form-group">
            <label for="fecha">Fecha de Realización del Pago</label>
            <input type="date" name="fecha" class="form-control" placeholder="Seleccione la fecha de realización del pago">
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="registrar" name="registrar">Guardar</button>
      </div>
    </div>
  </div>
</div>

  </div>

  <!-- /.content-wrapper -->
  <?php include('views/layout/footer.php'); ?>
  <script src="public/js/reporte.js"></script>