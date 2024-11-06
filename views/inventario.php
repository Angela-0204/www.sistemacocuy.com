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
                                <th>Categoria</th>
                                <th>Marca</th>
                                <th>Lote</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Empaquetado</th>
                                <th>Estatus</th>
                                <th>Ultima actualización</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data_products as $data) { ?>
                                <tr>
                                    <td><?php echo $data['cod_inventario'] ?></td>
                                    <td><?php echo $data['nombre'] ?></td>
                                    <td><?php echo $data['descripcion'] ?></td>
                                    <td><?php echo $data['nombre_categoria'] ?></td>
                                    <td><?php echo $data['marca'] ?></td>
                                    <td><?php echo $data['lote'] ?></td>
                                    <td><?php echo $data['precio_venta'] ?></td>
                                    <td><?php echo $data['stock'] ?></td>
                                    <td><?php echo $data['cantidad'] ?></td>
                                    <td><?php echo $data['estatus'] ?></td>
                                   

                                    <td><?php echo date('d/m/Y H:i', strtotime($data['fyh_actualizacion'])); ?></td>

                                    <td>
                                        <button onclick="editar(<?=$data['cod_inventario'];?>)" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="eliminar(<?=$data['cod_inventario'];?>)" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal editar producto -->
<div class="modal fade" id="modal-edit-producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <input type="hidden" id="cod_inventario" name="cod_inventario">
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
                    <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Escriba aqui una breve descripción del producto" maxlength="100">
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
                    <label for="caja">Unidades de la caja <span class="required">*</span></label>
                    <select name="caja" id="caja" class="form-control">
                        <?php foreach ($data_cajas as $cajas) { ?>
                            <option value="<?= $cajas['id_empaquetado']; ?>"><?= $cajas['cantidad']; ?></option>
                        <?php } ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="stock">Cantidad de productos</label>
                    <input type="text" name="stock" disabled id="stock" class="form-control" placeholder="Escriba aquí la cantidad en cajas del producto">
                    <span id="stockError" class="text-danger"></span>
                </div>

                <div class="col-md-6 form-group">
                    <label for="precio">Precio por caja del producto <span class="required">*</span></label>
                    <input type="text" step="0.01" name="precio" id="precio" class="form-control" placeholder="Escriba aquí el precio del producto por caja">
                    <span id="precioError" class="text-danger"></span>
                </div>

                <div class="col-md-6 form-group">
                    <label for="lote">Lote <span class="required">*</span></label>
                    <input type="text" name="lote" id="lote" class="form-control" placeholder="Escriba aquí el lote del producto">
                    <span id="loteError" class="text-danger"></span>
                </div>

                <div class="col-md-6 form-group">
                    <label for="estatus">Estatus <span class="required">*</span></label>
                    <select class="form-control" name="estatus">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="fecha">Fecha de expedición del producto <span class="required">*</span></label>
                    <input type="date" name="fecha" class="form-control" id="fecha">
                    <span id="fechaError" class="text-danger"></span>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="imagen">Agregar imagen del producto</label>
                    <input class="form-control" name="imagen" type="file" id="imagen">
                    <span id="imagenError" class="text-danger"></span>
                </div>
            </div>
            <hr>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="modificar" disabled>Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include('views/layout/footer.php'); ?>
<script src="public/js/inventario.js"></script>
