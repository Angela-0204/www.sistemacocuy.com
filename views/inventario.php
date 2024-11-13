<?php include('views/layout/menu.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> <!-- Ajusta el valor de margin-top según tus necesidades -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Productos en inventario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="row" style="margin-right: 20px;">
        <div class="col-12">
            <div class="card ml-15 " style="margin-left: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Tabla de inventario </h3>
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
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Cod.</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Última actualización</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_products as $data) { ?>
                            <tr>
                                <td><?php echo $data['cod_inventario']; ?></td>
                                <td><?php echo $data['nombre']; ?></td>
                                <td><?php echo $data['descripcion']; ?></td>
                                <td><?php echo $data['nombre_categoria']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($data['fyh_actualizacion'])); ?></td>
                                <td>
                                    <a href="?pagina=editar_producto&id=<?=$data['cod_inventario'];?>" title="Editar producto" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="detalles(<?=$data['cod_inventario'];?>)" title="Ver detalles" class="btn btn-success btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="eliminar(<?=$data['cod_inventario'];?>)" title="Eliminar producto"  class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para mostrar los detalles de inventario (todos los registros) -->
<div class="modal fade" id="modalDetallesInventario" tabindex="-1" aria-labelledby="modalDetallesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetallesLabel">Detalles del Inventario</h5>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Cantidad de Empaquetado</th>
              <th>Stock</th>
              <th>Lote</th>
              <th>Precio de Venta</th>
            </tr>
          </thead>
          <tbody id="tablaDetallesInventario">
            <!-- Aquí se cargarán los registros -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<?php include('views/layout/footer.php'); ?>
<script src="public/js/inventario.js"></script>
