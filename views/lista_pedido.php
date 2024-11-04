<?php include('views/layout/menu.php'); ?>
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
                  <?php
                  $contador = 0;
                  foreach ($data_pedido as $pedido_dato) {
                    $status = $pedido_dato['estatus'] == 1 ? 'Activo': 'Inactivo'; ?>

                    <tr style="text-align: center;">
                      <td><?php echo 'A-000'.$pedido_dato['id_pedido']; ?></td>
                      <td><?php echo date("d/m/Y", strtotime($pedido_dato['fecha_pedido'])); ?></td>
                      <td><?php echo $pedido_dato['nombre_cliente'].' '.$pedido_dato['apellido']; ?></td>
                      <td><?php echo $status ?></td>
                      <td>
                        <button onclick="editar(<?=$pedido_dato['id_presentacion'];?>)" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="eliminar(<?=$pedido_dato['id_presentacion'];?>)" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  <?php
                  } ?>
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

<!-- Modal de Bootstrap para "Agregar Productos" -->
<div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="agregarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarProductoModalLabel">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                  
                <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="">Nombre Producto</label>
                        <select name="nombre" id="nombre" class="form-control">
                          <?php foreach ($data_nombre as $nombre) { ?>
                            <option value="<?= $nombre['cod_inventario']; ?>"><?php echo $categorias['nombre']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="">Categoria del producto</label>
                        <select name="categoria" id="categoria" class="form-control">
                          <?php foreach ($data_categorias as $categorias) { ?>
                            <option value="<?= $categorias['id_categoria']; ?>"><?php echo $categorias['nombre_categoria']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-md-6 form-group">
                        <label for="">Marca</label>
                        <select name="marca" id="marca" class="form-control">
                          <?php foreach ($data_pedido as $pedido_dato) { ?>
                            <option value="<?= $pedido_dato['id_presentacion']; ?>"><?php echo $pedido_dato['marca']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    <div class="form-group">
                        <label for="precioProducto">Cantidad de Productos</label>
                        <input type="number" class="form-control" id="cantidad" placeholder="Cantidad de Productos">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar Producto</button>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($script)) {
    echo $script;
} ?>
<?php include('views/layout/footer.php'); ?>
