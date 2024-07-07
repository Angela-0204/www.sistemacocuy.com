<?php include('views/layout/menu.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" > 
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Movimientos De Usuarios</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="row" style="margin-right: 20px;" >
        <div class="col-12">
            <div class="card ml-15 " style="margin-left: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Tabla de Movimientos</h3>
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
                                <th>Codigo de Movimiento</th>
                                <th>Codigo de Usuario</th>
                                <th>Codigo de Pedido</th>
                                <th>Categoria</th>
                                <th>Codigo de Reporte de pago </th>
                                <th>Precio venta</th>
                                <th>Fecha de movimientos</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('views/layout/footer.php'); ?>
