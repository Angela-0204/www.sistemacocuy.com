<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Agregar Producto</h1>
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
                <h3 class="card-title mb-0">Registrar productos en inventario</h3>

              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="card-body">
              <div class="row">
                  <div class="col-md-12">
                      <h6 style="color: red;">* Campos obligatorios</h6>
                      
                      <!-- Sección 1: Datos Principales del Producto -->
                      <form action="" method="post" enctype="multipart/form-data" id="productoForm">
                          <h5>Datos Principales del Producto</h5>
                          <div class="row">
                              <div class="col-md-6 form-group">
                                  <label for="nombre">Nombre del producto <span class="required">*</span></label>
                                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escriba aquí el nombre del producto" maxlength="50">
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
                                  <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Escriba aquí una breve descripción del producto" maxlength="100">
                                  <span id="descripcionError" class="text-danger"></span>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6 form-group">
                                  <label for="categoria">Categoría del producto <span class="required">*</span></label>
                                  <select name="categoria" id="categoria" class="form-control">
                                      <?php foreach ($data_categorias as $categorias) { ?>
                                          <option value="<?= $categorias['id_categoria']; ?>"><?= $categorias['nombre_categoria']; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                              <div class="col-md-6 form-group">
                                  <label for="fecha">Fecha de expedición del producto <span class="required">*</span></label>
                                  <input type="date" name="fecha" class="form-control" id="fecha">
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
                      </form>
                  </div>

                  <!-- Sección 2: Detalle de Inventario -->
                  <div class="col-md-12 mt-4">
                      <h5>Detalle de Inventario</h5>
                      <div class="mb-3">
                          <button type="button" class="btn btn-primary" id="agregarDetalle" onclick="agregarDetalle()">Agregar Detalle de Inventario</button>
                      </div>

                      <!-- Tabla para mostrar detalles de inventario agregados -->
                      <table id="detalleInventarioTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Empaquetado</th>
                                <th>Stock</th>
                                <th>Lote</th>
                                <th>Unidad de Medida</th>
                                <th>Precio Venta</th>
                                <th>Estatus</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Filas dinámicas de detalle de inventario -->
                        </tbody>
                    </table>
                    <div>
                      <button class="btn btn-success" disabled id="registrar">Registrar</button>
                    </div>
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
<script src="<?php echo $URL;?>/public/js/producto.js"></script>
