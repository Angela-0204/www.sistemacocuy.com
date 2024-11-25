<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Editar Producto</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header d-flex align-items-center">
              <div class="d-flex align-items-center">
                <h3 class="card-title mb-0">Modificar producto en inventario</h3>

              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="card-body">
              <div class="row">
              <div class="container">
                <h2>Editar Producto</h2>

                <!-- Formulario para datos principales del producto -->
                <form action="" method="post" enctype="multipart/form-data" id="productoForm">

                      <h6 style="color: red;">* Campos obligatorios</h6>
                          <h5>Datos Principales del Producto</h5>
                          <div class="row">
                           
                              <div class="col-md-6 form-group">
                                  <label for="nombre">Nombre del producto <span class="required">*</span></label>
                                  <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($productoData['nombre']); ?>" placeholder="Escriba aquí el nombre del producto" maxlength="50">
                                  <span id="nombreError" class="text-danger"></span>
                              </div>
                              <div class="col-md-6 form-group">
                                  <label for="marca">Marca <span class="required">*</span></label>
                                  <select name="marca" id="marca" class="form-control">
                                      <?php foreach ($data_marcas as $marcas_dato) { ?>
                                          <option value="<?= $marcas_dato['id_presentacion']; ?>"><?= $marcas_dato['marca']; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12 form-group">
                                  <label for="descripcion">Descripción del producto</label>
                                  <input type="text" name="descripcion" id="descripcion" value="<?= htmlspecialchars($productoData['descripcion']); ?>"  class="form-control" placeholder="Escriba aquí una breve descripción del producto" maxlength="100">
                                  <span id="descripcionError" class="text-danger"></span>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6 form-group">
                                  <label for="categoria">Categoría del producto <span class="required">*</span></label>
                                  <select id="categoria" name="categoria" class="form-control">
                                    <?php foreach ($data_categorias as $categoria) { ?>
                                        <option value="<?= $categoria['id_categoria']; ?>" <?= $productoData['id_categoria'] == $categoria['id_categoria'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($categoria['nombre_categoria']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                              </div>
                              <div class="col-md-6 form-group">
                                  <label for="fecha">Fecha de expedición del producto <span class="required">*</span></label>
                                  <?php
                                        // Suponiendo que $productoData['fyh_creacion'] contiene la fecha en formato 'yyyy-mm-dd'
                                        $fechaCreacion = $productoData['fyh_creacion'];

                                        // Crear un objeto DateTime desde la fecha
                                        $date = new DateTime($fechaCreacion);

                                        // Formatear la fecha a 'dd/mm/yyyy'
                                        $fechaFormateada = $date->format('d/m/Y'); 
                                    ?>
                                  <input type="date" id="fecha" name="fecha" class="form-control" value="<?= htmlspecialchars($productoData['fyh_creacion']); ?>">
                                  <span id="fechaError" class="text-danger"></span>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12 form-group mb-3">
                                  <label for="imagen">Agregar imagen del producto</label>
                                  <input class="form-control" name="imagen" type="file" id="imagen">
                                  <span id="imagenError" class="text-danger"></span>
                              </div>
                          </div>
                        <button id="modificar" class="btn btn-success">Guardar Cambios</button>
                    <hr>
                    </form>
                    <h3>Detalles del Inventario</h3>
                      <div class="mb-3">
                          <button type="button" class="btn btn-primary" id="agregarDetalle" onclick="agregarDetalle()">Agregar Detalle de Inventario</button>
                      </div>
                      <table id="detalleInventarioTable" class="table">
                        <thead>
                            <tr>
                                <th>Empaquetado</th>
                                <th>Unidad de medida</th>
                                <th>Stock</th>
                                <th>Lote</th>
                                <th>Precio Venta</th>
                                <th>Estatus</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detallesInventario as $detalle) { ?>
                                <tr data-id-detalle="<?= htmlspecialchars($detalle['id_detalle_inventario']); ?>">
                                    <td data-empaquetado-id="<?= htmlspecialchars($detalle['id_empaquetado']); ?>"><?= htmlspecialchars($detalle['empaquetado']); ?></td>
                                    <td data-unidad-id="<?= htmlspecialchars($detalle['cod_unidad']); ?>"><?= htmlspecialchars($detalle['medida']); ?></td>
                                    <td contenteditable="true" onblur="actualizarValor(this, 'stock')"><?= htmlspecialchars($detalle['stock']); ?></td>
                                    <td contenteditable="true" onblur="actualizarValor(this, 'lote')"><?= htmlspecialchars($detalle['lote']); ?></td>
                                    <td contenteditable="true" onblur="actualizarValor(this, 'precio_venta')"><?= htmlspecialchars($detalle['precio_venta']); ?></td>
                                    <td>
                                        <select class="form-control">
                                            <option value="activo" <?= $detalle['estatus'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                            <option value="inactivo" <?= $detalle['estatus'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                        </select>
                                    </td>
                                    <td>
                                        <!-- Botón de guardar (disquete) oculto por defecto -->
                                        <button type="button" class="btn btn-warning btn-sm disquete" style="display:none" onclick="guardarCambios(this)">
                                            <i class="fa fa-floppy-o"></i> Guardar
                                        </button>
                                        <!-- Botón de eliminar -->
                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarDetalle(this)">Eliminar</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>


              </div>

              </div>

              <!-- Modal para agregar Detalle de Inventario -->
              <div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="detalleModalLabel">Agregar Detalle de Inventario</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form id="detalleForm">
                                  <div class="form-group">
                                      <label for="empaquetado">Empaquetado <span class="required">*</span></label>
                                      <select name="empaquetado" id="empaquetado" class="form-control">
                                          <?php foreach ($data_cajas as $cajas) { ?>
                                              <option value="<?= $cajas['id_empaquetado']; ?>"><?= $cajas['cantidad']; ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                  <label for="medida">Unidad de Medida <span class="required">*</span></label>
                                  <select name="medida" id="medida" class="form-control">
                                      <?php foreach ($data_medida as $medida_dato) { ?>
                                          <option value="<?= $medida_dato['cod_unidad']; ?>"><?= $medida_dato['medida']; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                                  <div class="form-group">
                                      <label for="stock">Cantidad de productos</label>
                                      <input type="number" name="stock" id="stock" class="form-control" placeholder="Escriba aquí la cantidad en cajas del producto">
                                      <span id="stockError" class="text-danger"></span>

                                  </div>
                                  <div class="form-group">
                                      <label for="lote">Lote <span class="required">*</span></label>
                                      <input type="text" name="lote" id="lote" class="form-control" placeholder="Escriba aquí el lote del producto">
                                      <span id="loteError" class="text-danger"></span>

                                  </div>
                                  <div class="form-group">
                                      <label for="precio">Precio por caja del producto <span class="required">*</span></label>
                                      <input type="number" step="0.01" name="precio" id="precio" class="form-control" placeholder="Escriba aquí el precio del producto por caja">
                                      <span id="precioError" class="text-danger"></span>

                                  </div>
                                  <div class="form-group">
                                      <label for="estatus">Estatus <span class="required">*</span></label>
                                      <select name="estatus" id="estatus" class="form-control">
                                          <option value="activo">Activo</option>
                                          <option value="inactivo">Inactivo</option>
                                      </select>
                                  </div>
                                  <button type="button" onclick="guardarDetalle()" class="btn btn-primary">Guardar Detalle</button>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>


            </div>

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
<?php include('views/layout/footer.php'); ?>
<script src="<?php echo $URL;?>/public/js/editar_producto.js"></script>
