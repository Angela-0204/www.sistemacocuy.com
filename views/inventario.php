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
                <div class="text-right">
                    <a href="views/fpdf/PruebaV.php"  target="_blank"  class="btn btn-success">Generar reporte</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Codigo de Producto</th>
                                <th>Nombre del Producto</th>
                                <th>Descripción</th>
                                <th>Categoria</th>
                                <th>Marca</th>
                                <th>Lote</th>
                                <th>Precio</th>
                                <th>Empaquetado</th>
                                <th>Estatus</th>
                                <th>Ultima actualizacion</th>
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
                                    <td><?php echo $data['stock'] ?></td>
                                    <td><?php echo $data['precio_venta'] ?></td>
                                    <td><?php echo $data['estatus'] ?></td>
                                   

                                    <td><?php echo date('d/m/Y H:i', strtotime($data['fyh_actualizacion'])); ?></td>

                                    <td>
                                        <a href="?pagina=inventario&accion=consultar&id=<?= $data['cod_inventario']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                        </a>  
                                        <a href="?pagina=inventario&accion=eliminar&id=<?= $data['cod_inventario']; ?>" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
<?php
if (isset($script)) {
    echo $script;
} ?>
<?php include('views/layout/footer.php'); ?>