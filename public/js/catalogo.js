// Evento cuando cambia el primer select (inventario)
document.getElementById('inventarioSelect').addEventListener('change', function () {
    const inventarioId = this.value;
    
    // Llamada AJAX para cargar las presentaciones del inventario seleccionado
    $.ajax({
        url: '',
        type: 'POST',
        data: { cod_inventario: inventarioId },
        dataType: 'json',
        success: function (data) {
            const presentacionSelect = $('#presentacionSelect');
            presentacionSelect.html('<option selected disabled value="">Seleccione una presentación</option>');

            data.forEach(function (presentacion) {
                presentacionSelect.append(
                    `<option value="${presentacion.id_detalle_inventario}" data-stock="${presentacion.stock}" data-price="${presentacion.precio_venta}" data-id-presentacion="${presentacion.id_presentacion}">
                        Empaquetado ${presentacion.id_presentacion} unidades - Precio: ${presentacion.precio_venta}$
                    </option>`
                );
            });

            presentacionSelect.prop('disabled', false);
        },
        error: function () {
            alert('Error al cargar las presentaciones.');
        }
    });
});

// Evento cuando cambia el segundo select (presentación)
document.getElementById('presentacionSelect').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const stock = selectedOption.getAttribute('data-stock');
    const price = selectedOption.getAttribute('data-price');

    // Actualiza los campos de stock y precio en el formulario
    document.getElementById('productStock').value = stock;
    document.getElementById('productPrice').value = price;
});

document.getElementById('addProductBtn').addEventListener('click', function () {
    const presentacionSelect = document.getElementById('presentacionSelect');
    const presentacionId = presentacionSelect.value;
    const idPresentacion = presentacionSelect.options[presentacionSelect.selectedIndex].getAttribute('data-id-presentacion');
    const productName = document.getElementById('inventarioSelect').options[document.getElementById('inventarioSelect').selectedIndex].text;
    const productPrice = parseFloat(presentacionSelect.options[presentacionSelect.selectedIndex].getAttribute('data-price'));
    const productStock = parseInt(presentacionSelect.options[presentacionSelect.selectedIndex].getAttribute('data-stock'));
    const productQuantity = parseInt(document.getElementById('productQuantity').value);

    // Validar que la cantidad no exceda el stock disponible
    if (productQuantity > productStock) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: `La cantidad solicitada excede el stock disponible (${productStock} unidades).`
        });  
        return;
    }

    const existingRow = document.querySelector(`#orderTable tbody tr[data-product-id="${presentacionId}"]`);
    if (existingRow) {
        // Producto ya existe en la tabla, actualizar cantidad y subtotal
        const quantityInput = existingRow.querySelector('.product-quantity');
        const newQuantity = parseInt(quantityInput.value) + productQuantity;

        // Validar de nuevo que la nueva cantidad no exceda el stock
        if (newQuantity > productStock) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: `La cantidad solicitada excede el stock disponible (${productStock} unidades).`
            });
            return;
        }

        const newSubtotal = productPrice * newQuantity;
        quantityInput.value = newQuantity;
        existingRow.querySelector('.subtotal').innerText = `$${newSubtotal.toFixed(2)}`;
    } else {
        // Crear una nueva fila para el producto
        const orderTableBody = document.getElementById('orderTable').getElementsByTagName('tbody')[0];
        const newRow = document.createElement('tr');
        newRow.setAttribute('data-product-id', presentacionId);
        const subtotal = productPrice * productQuantity;
        newRow.innerHTML = `
            <td>${productName}</td>
            <td><input type="number" class="form-control product-quantity" value="${productQuantity}" min="1" max="${productStock}" style="width: 80px;"></td>
            <td>$${productPrice.toFixed(2)}</td>
            <td>${productStock}</td> <!-- Columna de stock -->
            <td>${idPresentacion} unidades</td> <!-- Columna de empaquetado -->
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
            let newQuantity = parseInt(this.value);

            // Validación para impedir valores menores a 1
            if (newQuantity < 1) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La cantidad no puede ser menor que 1."
                });
                this.value = 1; // Restablece el valor a 1 si es menor
                newQuantity = 1;
            }

            // Validación para no exceder el stock disponible
            if (newQuantity > productStock) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: `La cantidad solicitada excede el stock disponible (${productStock} unidades).`
                });
                this.value = productStock; // Limitar al stock máximo
                newQuantity = productStock;
            }

            // Actualizar subtotal y total
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

$("#registrar").click(function (e) {
    e.preventDefault(); 
    console.log("Evento de registrar clic detectado"); // Prueba de depuración
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("cod_cliente", $("#cod_cliente").val()); // Captura el ID del cliente seleccionado
  
    // Obtener la fecha del pedido
    var fecha_pedido = $("#orderDate").val(); // Captura la fecha seleccionada
    datos.append("fecha_pedido", fecha_pedido); // Agrega la fecha al FormData
  
    // Obtener productos de la tabla
    var productos = [];
    $('#orderTable tbody tr').each(function () {
        var cantidad = $(this).find('.product-quantity').val();
        var id_detalle_inventario = $(this).data('product-id'); // Asegúrate de que este atributo contenga el ID correcto
        productos.push({ cantidad: cantidad, id_detalle_inventario: id_detalle_inventario });
    });
    datos.append("productos", JSON.stringify(productos)); // Convertir a JSON
  // Prueba de depuración
      console.log("Datos enviados: ", {
          accion: "registrar",
          cod_cliente: $("#cod_cliente").val(),
          fecha_pedido: $("#orderDate").val(),
          productos: productos
    });
    // Llamar a la función AjaxRegistrar para enviar los datos
    AjaxRegistrar(datos);
  });
  
  function AjaxRegistrar(datos) {
    $.ajax({
        url: "", // Especifica la URL de tu script PHP
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (response) {
            console.log("Respuesta del servidor: ", response);
        
            try {
                var res = JSON.parse(response);
                if (res.estatus == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Pedido",
                        text: res.mensaje
                    });
                    setTimeout(function () {
                        window.location.reload(); // Recargar la página
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.mensaje || "Hubo un problema al registrar el pedido."
                    });
                }
            } catch (e) {
                console.error("Error al analizar JSON:", e);
                Swal.fire({
                    icon: "error",
                    title: "Error de servidor",
                    text: "El servidor devolvió una respuesta inesperada."
                });
            }
        },        
        error: function (err) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error en la solicitud."
            });
        },
    });
  }
  
  

function updateTotal() {
  let total = 0;

  // Selecciona todas las filas de la tabla de pedidos
  const rows = document.querySelectorAll("#orderTable tbody tr");

  // Recorre cada fila y suma los subtotales
  rows.forEach(row => {
      const subtotal = parseFloat(row.querySelector(".subtotal").innerText.replace('$', ''));
      total += subtotal;
  });

  // Actualiza el total en el DOM
  document.getElementById("totalAmount").innerText = total.toFixed(2);
}

document.getElementById('productQuantity').addEventListener('input', function () {
if (this.value < 1) {
  this.value = 1; // Restablece a 1 si el valor es menor
}
});


