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
                            <select class="form-control" id="clientSelect">
                                <?php foreach ($data_clientes as $clientes_dato) { ?>
                                      <option value="<?= $clientes_dato['id_cliente']; ?>"><?= $clientes_dato['nombre_cliente'].' '.$clientes_dato['apellido']; ?></option>
                                  <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="orderDate">Fecha de Pedido</label>
                            <input type="date" disabled class="form-control" id="orderDate">
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
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#agregarProductoModal">
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
                        <label for="productSelect">Producto</label>
                        <select class="form-control" id="productSelect">
                            <?php foreach ($data_productos as $productos_dato) { ?>
                                <option value="<?= $productos_dato['cod_inventario']; ?>"  data-name="<?= $productos_dato['nombre']; ?>" data-price="<?= $productos_dato['precio_venta']; ?>"><?= $productos_dato['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="productQuantity">Cantidad</label>
                        <input type="number" class="form-control" id="productQuantity" min="1" value="1">
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
<script>
    // Establecer la fecha actual en el campo de fecha
    document.getElementById('orderDate').valueAsDate = new Date();

    // Función para actualizar el total
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('#orderTable tbody tr').forEach(row => {
            const subtotal = parseFloat(row.querySelector('.subtotal').innerText.replace('$', ''));
            total += subtotal;
        });
        document.getElementById('totalAmount').innerText = total.toFixed(2);
    }

    // Agregar o actualizar producto en el pedido
    document.getElementById('addProductBtn').addEventListener('click', function () {
        const productSelect = document.getElementById('productSelect');
        const productId = productSelect.value;
        const productName = productSelect.options[productSelect.selectedIndex].getAttribute('data-name');
        const productPrice = parseFloat(productSelect.options[productSelect.selectedIndex].getAttribute('data-price'));
        const productQuantity = parseInt(document.getElementById('productQuantity').value);

        const existingRow = document.querySelector(`#orderTable tbody tr[data-product-id="${productId}"]`);
        if (existingRow) {
            // Producto ya existe en la tabla, actualizar cantidad y subtotal
            const quantityInput = existingRow.querySelector('.product-quantity');
            const newQuantity = parseInt(quantityInput.value) + productQuantity;
            const newSubtotal = productPrice * newQuantity;
            quantityInput.value = newQuantity;
            existingRow.querySelector('.subtotal').innerText = `$${newSubtotal.toFixed(2)}`;
        } else {
            // Crear una nueva fila para el producto
            const orderTableBody = document.getElementById('orderTable').getElementsByTagName('tbody')[0];
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-product-id', productId);
            const subtotal = productPrice * productQuantity;

            newRow.innerHTML = `
                <td>${productName}</td>
                <td><input type="number" class="form-control product-quantity" value="${productQuantity}" min="1" style="width: 80px;"></td>
                <td>$${productPrice.toFixed(2)}</td>
                <td class="subtotal">$${subtotal.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-product-btn">Eliminar</button></td>
            `;
            orderTableBody.appendChild(newRow);

            // Evento para eliminar producto
            newRow.querySelector('.remove-product-btn').addEventListener('click', function () {
                newRow.remove();
                updateTotal();
            });

            // Evento para editar cantidad y actualizar subtotal y total
            newRow.querySelector('.product-quantity').addEventListener('input', function () {
                const newQuantity = parseInt(this.value);
                const newSubtotal = productPrice * newQuantity;
                newRow.querySelector('.subtotal').innerText = `$${newSubtotal.toFixed(2)}`;
                updateTotal();
            });
        }

        // Limpiar y cerrar el modal
        document.getElementById('productForm').reset();
        $('#addProductModal').modal('hide');
        updateTotal();
    });
</script>


