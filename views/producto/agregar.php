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
                  <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="">Nombre del producto</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Escriba aquí el nombre del producto">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="">Descripción del producto</label>
                        <input type="text" name="descripcion" class="form-control" placeholder="Escriba aqui una breve descripción del producto">
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="">Marca</label>
                        <select name="marca" id="marca" class="form-control">
                          <?php foreach ($data_marcas as $marcas_dato) { ?>
                            <option value="<?= $marcas_dato['id_presentacion']; ?>"><?php echo $marcas_dato['marca']; ?></option>
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
                       <div class="row">
                      <div class="col-md-6 form-group">
                        
                        <label for="">Unidades de la caja</label>
                        <select name="caja" id="caja" class="form-control">
                          <?php foreach ($data_cajas as $cajas) { ?>
                            <option value="<?= $cajas['id_empaquetado']; ?>"><?php echo $cajas['cantidad']; ?></option>
                          <?php } ?>
                        </select>  
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="">Cantidad de productos</label>
                        <input type="number" name="stock" class="form-control" placeholder="Escriba aquí la cantidad en cajas del producto">
                      </div>
            
                      <div class="col-md-6 form-group">
                        <label for="">Precio por caja del producto</label>
                        <input type="text" name="precio" class="form-control" placeholder="Escriba aquí el precio del producto por caja">
                      </div>
                      
                      <div class="col-md-6 form-group">
                        <label for="">Lote</label>
                        <input type="text" name="lote" class="form-control" placeholder="Escriba aquí el lote del producto.">
                      </div>
                      
                      <div class="col-md-6 form-group">
                        <label for="">Estatus</label>
                        <input type="text" name="estatus" class="form-control" placeholder="Escriba aquí el estatus del producto">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="">Fecha de expedicion del producto</label>
                        <input type="date" name="fecha" class="form-control">
                      </div>
                      <div class=" col-md-6 form-group mb-3">

                        <label for="">Agregar imagen del producto</label>
                        <input class="form-control" name="imagen" id="formFileSm" type="file">
                      </div>
                    </div>
                    <div class="form-group">
                      <a href="" class="btn btn-secondary">Cancelar</a>
                      <button class="btn btn-primary" id="registrar" name="registrar">Guardar</button>

                    </div>
                    <hr>
                  </form>
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
<?php 
if (isset($script)) {
    echo $script;
}?>
<?php include('views/layout/footer.php'); ?>