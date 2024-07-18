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
                <div class="col-md-8">
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
                                        <input type="hidden" name="accion" value="modificar">
                                        <?php foreach ($data as $value) { ?>
                                            <input type="hidden" name="id" value="<?php echo $value['id_producto']; ?>">
                                            <div class="form-group">
                                                <label for="">Nombre del producto</label>
                                                <input type="text" name="nombre" value="<?php echo $value['nombre']; ?>" class="form-control" placeholder="Escriba aquí el nombre del producto">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Codigo de producto</label>
                                                <input type="text" name="codigo" value="<?php echo $value['codigo']; ?>" class="form-control" placeholder="Escriba aquí el codigo del producto">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Descripcion del producto</label>
                                                <input type="text" name="descripcion" class="form-control" value="<?php echo $value['descripcion']; ?>" placeholder="Escriba aqui una breve descripcion del producto">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Categoria del producto</label>
                                                <select name="categoria" id="categoria" class="form-control">
                                                    <?php foreach ($data_categorias as $categorias) { ?>
                                                        <option value="<?= $categorias['id_categoria']; ?>"><?php echo $categorias['nombre_categoria']; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Cantidad minima permitida en inventario</label>
                                                <input type="text" name="stock_minimo" class="form-control" value="<?php echo $value['stock_minimo']; ?>" placeholder="Escriba aquí la cantidad minima de este producto en el inventario">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Cantidad maxima permitida en inventario</label>
                                                <input type="text" name="stock_maximo" class="form-control" value="<?php echo $value['stock_maximo']; ?>" placeholder="Escriba aquí la cantidad maxima de este producto en el inventario">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Precio por caja del producto</label>
                                                <input type="text" name="precio" class="form-control" value="<?php echo $value['precio_venta']; ?>" placeholder="Escriba aquí el precio del producto por caja">
                                            </div>
                                            <div class=" form-group mb-3">

                                                <label for="">Agregar imagen del producto</label>
                                                <input class="form-control " name="imagen" id="formFileSm" type="file">
                                            </div>
                                        <?php } ?>

                                        <div class="form-group">
                                            <a href="" class="btn btn-secondary">Cancelar</a>
                                            <button id="modificar" class="btn btn-primary">Guardar</button>
                                        </div>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="<?= $data[0]['imagen']; ?>" alt="" class="img-fluid">
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
} ?>
<?php include('views/layout/footer.php'); ?>