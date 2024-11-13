<?php include('views/layout/menu.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> <!-- Ajusta el valor de margin-top según tus necesidades -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Gestión de pedido</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="row" style="margin-right: 20px;">
        <div class="col-12">
            <div class="card ml-15" style="margin-left: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Nuevo Pedido </h3>
                </div>

                <div class="container mt-3">
                    <!-- Selección de Cliente y Fecha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="clientSelect">Seleccionar Cliente</label>
                            <select class="form-control" id="cod_cliente">
                                <?php foreach ($data_clientes as $clientes_dato) { ?>
                                    <option value="<?= $clientes_dato['cod_cliente']; ?>"><?= $clientes_dato['nombre_cliente'].' '.$clientes_dato['apellido']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="orderDate">Fecha de Pedido</label>
                            <input type="date" class="form-control" id="orderDate" value="<?= date('Y-m-d'); ?>" disabled>
                        </div>

                    </div>

                    <!-- Botón para agregar productos al pedido -->
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">
                        Agregar Producto
                    </button>

                    <!-- Tabla para mostrar productos seleccionados -->
                    <div class="card-body table-responsive p-0">
                        <table id="orderTable" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Stock</th> 
                                    <th>Empaquetado</th> 
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se cargarán los productos seleccionados -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Total acumulado -->
                    <div class="mt-3">
                        <h4>Total: $<span id="totalAmount">0.00</span></h4>
                    </div>
                </div>
                <!-- Botón "Agregar Productos" que abre la modal -->
                <div class="card-footer">
                    <button type="button" class="btn btn-success" id="registrar">
                        Guardar Pedido <i class="fa fa-save"></i>
                    </button>
                </div>

            </div> 
        </div>
    </div>
</div>

<!-- Modal para agregar producto -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Seleccionar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para seleccionar producto y cantidad -->
                <form id="productForm">
                    <div class="form-group">
                        <label for="inventarioSelect">Inventario</label>
                        <select class="form-control" id="inventarioSelect">
                            <option selected disabled value="">Seleccione un inventario</option>
                            <?php foreach ($data_inventarios as $inventario) { ?>
                                <option value="<?= $inventario['cod_inventario']; ?>"><?= htmlspecialchars($inventario['nombre']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="presentacionSelect">Presentación</label>
                        <select class="form-control" id="presentacionSelect" disabled>
                            <option selected disabled value="">Seleccione una presentación</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="productQuantity">Cantidad</label>
                                <input type="number" class="form-control" id="productQuantity" min="1" value="1">
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <label>Stock disponible:</label>
                                <input type="text" disabled class="form-control" id="productStock">
                            </div>
                        </div>
                    </div>
                    

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="addProductBtn">Agregar al Pedido</button>
            </div>
        </div>
    </div>
</div>


<?php
if (isset($script)) {
    echo $script;
} ?>
<?php include('views/layout/footer.php'); ?>
<!-- JavaScript para manejar la adición de productos a la tabla -->
<script src="public/js/catalogo.js"></script>