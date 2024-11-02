$("#registrar").click(function (e) {
    e.preventDefault();
    var datos = new FormData();
    datos.append("accion", "registrar"); // Cambiado aquí
    datos.append("nombre", $("input[name='nombre']").val());
    datos.append("descripcion", $("input[name='descripcion']").val());
    datos.append("marca", $("select[name='marca']").val());
    datos.append("categoria", $("select[name='categoria']").val());
    datos.append("stock", $("input[name='stock']").val());
    datos.append("precio", $("input[name='precio']").val());
    datos.append("fecha", $("input[name='fecha']").val());
    datos.append("caja", $("select[name='caja']").val());
    datos.append("lote", $("select[name='lote']").val());
    datos.append("estatus", $("select[name='estatus']").val());
    datos.append("imagen", $("input[name='imagen']")[0].files[0]);

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
        error: function (err) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error en la solicitud."
            });
        },
    });
}


function showError(field, message) {
    document.getElementById(field + "Error").textContent = message;
}

function clearError(field) {
    document.getElementById(field + "Error").textContent = "";
}

function restrictInput(event, regex, field, errorMsg) {
    const key = event.key;
    if (!regex.test(key) && key !== "Backspace" && key !== "Tab") {
        event.preventDefault();
        showError(field, errorMsg); // Muestra mensaje solo si el caracter es incorrecto
    } else {
        clearError(field); // Limpia el mensaje si el caracter es permitido
    }
}

// Bloqueo de caracteres no permitidos en `keypress`
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

function enableSubmit() {
    const isFormValid =
        validateNombre() &&
        validateStock() &&
        validatePrecio() &&
        validateLote() &&
        validateFecha() &&
        document.getElementById("descripcion").value &&
        document.getElementById("categoria").value &&
        document.getElementById("caja").value;

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

