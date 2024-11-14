function AjaxModificar(datos) {
    $.ajax({
        url: "",  // Vacío, porque estamos en el mismo archivo
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (res) {
            try {

                if (res.estatus == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Producto",
                        text: res.mensaje
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.mensaje
                    });
                }
            } catch (error) {
                console.error("Error al parsear JSON:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error en la respuesta del servidor."
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud:", error);
            console.log(xhr.responseText); // Mostrar la respuesta del servidor
        }
    });
}

function agregarDetalle() {
    // Abre el modal para agregar el detalle
    $('#detalleModal').modal('show');
  }

  function guardarDetalle() {
    const presentacionId = $('#presentacion').val();
    const empaquetadoId = $('#empaquetado').val();
    const presentacionText = $('#presentacion option:selected').text();
    const empaquetadoText = $('#empaquetado option:selected').text();
    const stock = $('#stock').val();
    const lote = $('#lote').val();
    const precio = $('#precio').val();
    const estatus = $('#estatus').val();
    const marca =  $("select[name='marca']").val();

    $.ajax({
        url: '', // Reemplaza con la URL del controlador para guardar los cambios
        method: 'POST',
        data: {
            accion: 'nuevo_detalle',
            empaquetadoId: empaquetadoId,
            stock: stock,
            lote: lote,
            precio: precio,
            estatus: estatus,
            marca:marca
        },
        success: function(response) {
            var res = JSON.parse(response);   
            if (res.estatus === 1) {
                // Ocultar el disquete después de guardar

                $('#detalleInventarioTable tbody').append(`
                    <tr data-id-detalle="">
                        <td data-empaquetado-id="${empaquetadoId}">${empaquetadoText}</td>
                        <td contenteditable="true" onblur="actualizarValor(this, 'stock')">${stock}</td>
                        <td contenteditable="true" onblur="actualizarValor(this, 'lote')">${lote}</td>
                        <td contenteditable="true" onblur="actualizarValor(this, 'precio')">${precio}</td>
                        <td>
                            <select class="form-control" onchange="actualizarValor(this, 'estatus')">
                                <option value="activo" ${estatus === 'activo' ? 'selected' : ''}>Activo</option>
                                <option value="inactivo" ${estatus === 'inactivo' ? 'selected' : ''}>Inactivo</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm disquete" style="display:none" onclick="guardarCambios(this)">
                                <i class="fa fa-floppy-o"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarDetalle(this)">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `);

                // Cierra el modal y limpia el formulario
                $('#detalleModal').modal('hide');
                $('#detalleForm')[0].reset();
                Swal.fire({
                    icon: "success",
                    title: "Detalle del Producto",
                    text: res.mensaje
                });
                row.find('.disquete').hide();
            } else {
                Swal.fire({
                        icon: "warning",
                        title: "Detalle del Producto",
                        text: res.mensaje
                    });
                console.log('Error al guardar cambios.');
            }
        },
        error: function() {
            console.log('Error de comunicación con el servidor.');
        }
    });
    

}

// Función para eliminar un detalle
function eliminarDetalle(button) {
    // Obtener el ID del detalle que se va a eliminar
    var row = $(button).closest('tr');
    var idDetalle = row.data('id-detalle'); // id_detalle_inventario de la fila
    
    // Eliminar visualmente la fila
    row.remove();

    // Enviar al backend para eliminar el detalle de la base de datos
    $.ajax({
        url: '', // Reemplaza con la URL del controlador para eliminar el detalle
        method: 'POST',
        data: {
            accion: 'eliminar_detalle',
            id_detalle_inventario: idDetalle
        },
        success: function(response) {
            var res = JSON.parse(response);   

            if (res.estatus === 1) {
                // Ocultar el disquete después de guardar
                row.find('.disquete').hide();
                Swal.fire({
                        icon: "success",
                        title: "Detalle del Producto",
                        text: res.mensaje
                    });
            } else {
                Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.mensaje
                    });
            }
        },
        error: function() {
            console.log('Error de comunicación con el servidor.');
        }
    });
}


$("#modificar").click(function (e) {
    e.preventDefault();

    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("nombre", $("input[name='nombre']").val());
    datos.append("descripcion", $("input[name='descripcion']").val());
    datos.append("categoria", $("select[name='categoria']").val());
    datos.append("marca", $("select[name='marca']").val());
    datos.append("fecha", $("input[name='fecha']").val());
    datos.append("imagen", $("input[name='imagen']")[0].files[0]);

    AjaxModificar(datos);
});

// Función para manejar los cambios en las celdas editables
function actualizarValor(elemento, campo) {
    // Encontrar la fila correspondiente al detalle
    var row = $(elemento).closest('tr');
    
    // Mostrar el botón de guardar (disquete) al detectar un cambio
    var disquete = row.find('.disquete');  // El ícono de disquete
    disquete.show();

    // Almacenar el valor actualizado en un objeto global si es necesario
    // Puedes almacenar los valores modificados para enviar al servidor
    var detalleId = row.data('id-detalle');  // ID del detalle
    var valor = $(elemento).text().trim();   // Valor actualizado
    
    // Guardamos el valor modificado en un objeto para seguimiento
    detallesModificados[detalleId] = detallesModificados[detalleId] || {};
    detallesModificados[detalleId][campo] = valor;
}

// Función para guardar los cambios de la fila modificada
function guardarCambios(button) {
    var row = $(button).closest('tr');
    var idDetalle = row.data('id-detalle'); // ID del detalle
    var stock = row.find('td:eq(1)').text().trim(); // Valor actualizado de stock
    var lote = row.find('td:eq(2)').text().trim(); // Valor actualizado de lote
    var precio = row.find('td:eq(3)').text().trim(); // Valor actualizado de precio
    var estatus = row.find('td:eq(4) select').val(); // Estatus seleccionado
    var marca = $("select[name='marca']").val();

    // Enviar los datos al backend para guardar los cambios
    $.ajax({
        url: '', // Reemplaza con la URL del controlador para guardar los cambios
        method: 'POST',
        data: {
            accion: 'guardar_detalle',
            id_detalle_inventario: idDetalle,
            stock: stock,
            lote: lote,
            precio: precio,
            estatus: estatus,
            marca: marca
        },
        success: function(response) {
            var res = JSON.parse(response);   
            if (res.estatus == 1) {
                // Ocultar el disquete después de guardar
                row.find('.disquete').hide();
                Swal.fire({
                        icon: "success",
                        title: "Detalle del Producto",
                        text: res.mensaje
                    });
                console.log('Cambios guardados correctamente.');
            } else {
                Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Error al guardar cambios."
                    });
                console.log('Error al guardar cambios.');
            }
        },
        error: function() {
            console.log('Error de comunicación con el servidor.');
        }
    });
}