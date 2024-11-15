<?php include('views/layout/menu.php'); ?>
<style>
    /* Define colores de estado */
    .status-activo {
        color: green;
        font-weight: bold;
    }

    .status-anulado {
        color: red;
        font-weight: bold;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> <!-- Ajusta el valor de margin-top según tus necesidades -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Pedidos registrados</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="row" style="margin-right: 20px;">
        <div class="col-12">
            <div class="card ml-15" style="margin-left: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Tabla de pedidos </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                <table id="examplel" class="table table-bordered table-atriped">
                <thead>
                  <tr>
                    <th>
                      <center>Cod. Pedido</center>
                    </th>
                    <th>
                      <center>Fecha</center>
                    </th>
                    <th>
                      <center>Clientes</center>
                    </th>
                    <th>
                      <center>Estatus</center>
                    </th>
                    <th>
                      <center>Accion</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($data_pedido as $pedido_dato) {
                      // Determina el estado y la clase de color para el estado
                      $status = $pedido_dato['estatus'] == 1 ? 'Activo' : 'Anulado';
                      $status_class = $pedido_dato['estatus'] == 1 ? 'status-activo' : 'status-anulado';
                  ?>

                  <tr style="text-align: center;">
                      <td><?php echo 'A-000' . $pedido_dato['id_pedido']; ?></td>
                      <td><?php echo date("d/m/Y", strtotime($pedido_dato['fecha_pedido'])); ?></td>
                      <td><?php echo $pedido_dato['nombre_cliente'] . ' ' . $pedido_dato['apellido']; ?></td>
                      <td class="<?= $status_class; ?>"><?php echo $status; ?></td>
                      <td>
                          <button onclick="mostrar(<?=$pedido_dato['id_pedido'];?>)" class="btn btn-warning btn-sm" title="Consultar Pedido">
                              <i class="fas fa-eye"></i>
                          </button>
                          <?php if ($pedido_dato['estatus'] == 1) { ?>
                              <button onclick="anular(<?=$pedido_dato['id_pedido'];?>)" class="btn btn-danger btn-sm" title="Anular Pedido">
                                  <i class="fas fa-minus-circle"></i>
                              </button>
                          <?php } ?>
                      </td>
                  </tr>
                  <?php } ?>

                </tbody>
              </table>
                </div>

                <!-- Botón "Agregar Productos" que abre la modal -->
                <div class="card-footer">
                </div>

            </div> 
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalPedido" tabindex="-1" role="dialog" aria-labelledby="modalPedidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalPedidoLabel">Detalles del Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Información general del pedido -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Código del Pedido:</strong> <span id="codigoPedido"></span></p>
                        <p><strong>Fecha del Pedido:</strong> <span id="fechaPedido"></span></p>                      
                    </div>
                    <div class="col-md-6">
                        <p><strong>Cliente:</strong> <span id="clientePedido"></span></p>
                        <p><strong>Usuario responsable:</strong> <span id="usuarioPedido"></span></p>
                    </div>
                </div>

                <!-- Detalles del pedido -->
                <h4 class="mb-3">Detalles del Pedido</h4>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Empaquetado</th>
                            <th>Unidad de Medida</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="detallePedido">
                        <!-- Los detalles del pedido se cargarán aquí dinámicamente -->
                    </tbody>
                </table>

                <!-- Total del pedido -->
                <div class="row">
                    <div class="col-md-12 text-right">
                        <h4><strong>Total: $<span id="totalPedido"></span></strong></h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <!-- Botón para generar PDF -->
                <button type="button" id="btnGenerarPDF" class="btn btn-success">Generar PDF</button>

                <a href="" class="btn btn-secondary">Cerrar</a>
            </div>
        </div>
    </div>
</div>


<?php include('views/layout/footer.php'); ?>
<script src="public/js/lista_pedido.js"></script>
