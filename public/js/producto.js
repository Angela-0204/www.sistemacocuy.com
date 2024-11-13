$("#registrar").click(function (e) {
    e.preventDefault();

    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("nombre", $("input[name='nombre']").val());
    datos.append("descripcion", $("input[name='descripcion']").val());
    datos.append("categoria", $("select[name='categoria']").val());
    datos.append("marca", $("select[name='marca']").val());
    datos.append("fecha", $("input[name='fecha']").val());
    datos.append("imagen", $("input[name='imagen']")[0].files[0]);

    $("#detalleInventarioTable tbody tr").each(function (index, row) {
        let empaquetadoId = $(row).find("td[data-empaquetado-id]").data("empaquetado-id");
        let stock = $(row).find("td:eq(1)").text().trim();
        let lote = $(row).find("td:eq(2)").text().trim();
        let precio = $(row).find("td:eq(3)").text().trim();
        let estatus = $(row).find("td:eq(4) select").val();

        datos.append(`detalles[${index}][empaquetado]`, empaquetadoId);
        datos.append(`detalles[${index}][stock]`, stock);
        datos.append(`detalles[${index}][lote]`, lote);
        datos.append(`detalles[${index}][precio]`, precio);
        datos.append(`detalles[${index}][estatus]`, estatus);
    });

    console.log("Datos enviados:", datos); // Imprime en consola para revisar

    AjaxRegistrar(datos);
});


function AjaxRegistrar(datos) {
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

//Para mostrar el error en el span
function showError(field, message) {
    //El contenido del mensaje se mostrará en el span que tenga el id field+Error (ejemplo nombreError)
    document.getElementById(field + "Error").textContent = message;
}

//Para limpiar el error en el span 
function clearError(field) {
    document.getElementById(field + "Error").textContent = "";
}

//Se evalua el campo y depende de eso se muestra o se limpia el error en el span correspondiente
//Se envia como parametros: el event, la expresion regular, el campo, y el mensaje de error que se mostrará
function restrictInput(event, regex, field, errorMsg) {
    const key = event.key;
    //Si se está recibiendo por teclado una tecla que no este en la exp reg, que no sea tecla de borrar ni tab    
    if (!regex.test(key) && key !== "Backspace" && key !== "Tab") {
        event.preventDefault();
        showError(field, errorMsg); // Muestra mensaje solo si el caracter es incorrecto
    } 
    //En caso que todas las teclas que se esten ingresando sean correctar
    else {
        clearError(field); // Limpia el mensaje si el caracter es permitido
    }
}

// Bloqueo de caracteres no permitidos en `keypress`, para validar en tiempo real
document.getElementById("nombre").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z0-9\s]$/, "nombre", "Solo se permiten letras y números.");
});

document.getElementById("stock").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "stock", "Solo se permiten números enteros.");
});

document.getElementById("precio").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9.]$/, "precio", "Solo se permiten números y punto decimal.");
});

document.getElementById("lote").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z0-9\-]$/, "lote", "Solo se permiten letras, números y guión.");
});

// Validaciones completas en `input`, sin mensajes de error
function validateNombre() {
    const nombre = document.getElementById("nombre").value;
    const nombreRegex = /^[A-Za-z0-9\s]{5,50}$/;
    if (!nombreRegex.test(nombre)) {
        showError("nombre", "El nombre debe tener entre 5 y 50 caracteres, solo letras y números.");
        return false;
    } else {
        clearError("nombre");
        return true;
    }
}

function validateDescripcion() {
    const descripcion = document.getElementById("descripcion").value;
    if (descripcion.length > 100) {
        showError("descripcion", "La descripción no debe superar los 100 caracteres.");
        return false;
    } else {
        clearError("descripcion");
        return true;
    }
}

function validateStock() {
    const stock = document.getElementById("stock").value;
    return Number.isInteger(Number(stock)) && stock > 0;
}

function validatePrecio() {
    const precio = document.getElementById("precio").value;
    const valor = parseFloat(precio);
    return !isNaN(valor) && valor > 0;
}

function validateLote() {
    const lote = document.getElementById("lote").value;
    return /^[A-Za-z0-9\-]*$/.test(lote);
}

function validateFecha() {
    const fecha = document.getElementById("fecha").value;
    return fecha !== "";
}

//Se valida de manera general
function enableSubmit() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateNombre() &&
        validateFecha() &&
        document.getElementById("descripcion").value && //Y aqui se validan que realmente tengan un valor estos campos
        document.getElementById("categoria").value;
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("registrar").disabled = !isFormValid;
}

// Asignar eventos `input` para validar el formulario y habilitar el botón de guardar sin mostrar mensajes de error
document.getElementById("nombre").addEventListener("input", enableSubmit);
document.getElementById("stock").addEventListener("input", enableSubmit);
document.getElementById("precio").addEventListener("input", enableSubmit);
document.getElementById("lote").addEventListener("input", enableSubmit);
document.getElementById("fecha").addEventListener("change", enableSubmit);
document.getElementById("descripcion").addEventListener("input", enableSubmit);
document.getElementById("categoria").addEventListener("change", enableSubmit);
document.getElementById("caja").addEventListener("change", enableSubmit);


function agregarDetalle() {
    // Abre el modal para agregar el detalle
    $('#detalleModal').modal('show');
  }

function guardarDetalle() {
    // Función para agregar una nueva fila a la tabla, similar al código anterior
    const presentacionId = $('#presentacion').val();
    const empaquetadoId = $('#empaquetado').val();
    const presentacionText = $('#presentacion option:selected').text();
    const empaquetadoText = $('#empaquetado option:selected').text();
    const stock = $('#stock').val();
    const lote = $('#lote').val();
    const precio = $('#precio').val();
    const estatus = $('#estatus').val();

    $('#detalleInventarioTable tbody').append(`
        <tr>
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
            <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarDetalle(this)">Eliminar</button></td>
        </tr>
    `);

    // Cierra el modal y limpia el formulario
    $('#detalleModal').modal('hide');
    $('#detalleForm')[0].reset();
}

// Función para actualizar el valor en la tabla y mantenerlo en el DOM
function actualizarValor(elemento, campo) {
    const nuevoValor = elemento.innerText || elemento.value;
    const fila = $(elemento).closest('tr');
    
    // Almacena el nuevo valor en un atributo de la fila para posibles actualizaciones futuras
    fila.data(campo, nuevoValor);
}



function eliminarDetalle(button) {
    // Elimina la fila seleccionada
    $(button).closest('tr').remove();
}

//Para modificar caja
$("#modificar").click(function (e) {
    e.preventDefault();

    var detalles = [];
    $("#detalleInventarioTable tbody tr").each(function () {
        var row = $(this);
        detalles.push({
            stock: row.find("td:eq(1)").text(),
            lote: row.find("td:eq(2)").text(),
            precio_venta: row.find("td:eq(3)").text(),
            estatus: row.find("select").val(),
            id_empaquetado: row.find("td:eq(0)").data("id_empaquetado") // Suponiendo que tienes el id del empaquetado
        });
    });

    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("nombre", $("input[name='nombre']").val());
    datos.append("descripcion", $("input[name='descripcion']").val());
    datos.append("marca", $("select[name='marca']").val());
    datos.append("categoria", $("select[name='categoria']").val());
    datos.append("fecha", $("input[name='fecha']").val());
    datos.append("imagen", $("input[name='imagen']")[0].files[0]);

    // Agregar detalles de inventario
    datos.append("detalles", JSON.stringify(detalles));

    // Llamada AJAX para modificar el producto
    AjaxRegistrar(datos);
});
