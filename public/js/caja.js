//Para registrar nueva caja
$("#registrar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("cantidad", $("input[name='cantidad']").val());
    datos.append("descripcion", $("input[name='descripcion']").val());
    AjaxRegistrar(datos);
});

//Para modificar caja
$("#modificar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("id_empaquetado", $("input[name='id']").val());
    datos.append("cantidad", $("input[name='cantidad_editar']").val());
    datos.append("descripcion", $("input[name='descripcion_editar']").val());
    funcionAjax(datos);
});

function editar(id){
    var datos = new FormData();
    datos.append("accion", "consultar");
    datos.append("id_empaquetado", id);
    AjaxEditar(datos);
}


//Para eliminar un registro
function eliminar(id) {
    Swal.fire({
        title: "¿Está seguro de eliminar el registro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonColor: "#0C72C4",
        cancelButtonColor: "#9D2323",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            setTimeout(function () {
                var datos = new FormData();
                datos.append("accion", "eliminar");
                datos.append("id", id);
                funcionAjax(datos);
            }, 10);
        }
    });
}


function AjaxRegistrar(datos) {
    $.ajax({
        url: "",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (response) {
            var res = JSON.parse(response);
            if (res.estatus == 1) {
                Swal.fire({
                    icon: "success",
                    title: "Empaquetado",
                    text: res.mensaje
                });
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar el empaquetado."
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


function funcionAjax(datos) {
    $.ajax({
        url: "",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (response) {
            var res = JSON.parse(response);
            if (res.estatus == 1) {
                Swal.fire({
                    icon: "success",
                    title: "Empaquetado",
                    text: res.mensaje
                });
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            }
            else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: res.mensaje
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


function AjaxEditar(datos) {
    $.ajax({
        url: "",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (response) {  
            var res = JSON.parse(response);   
            $("#id").val(res.id_empaquetado);
            $("#cantidad_editar").val(res.cantidad);
            $("#descripcion_editar").val(res.descripcion);
            $("#modal-edit-caja").modal("show");   
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
document.getElementById("cantidad").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "cantidad", "Solo se permiten números.");
});
// Bloqueo de caracteres no permitidos en `keypress`, para validar en tiempo real
document.getElementById("descripcion").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z0-9\s]$/, "descripcion", "Solo se permiten letras y números.");
});

document.getElementById("cantidad_editar").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "cantidad_editar", "Solo se permiten números.");
});
// Bloqueo de caracteres no permitidos en `keypress`, para validar en tiempo real
document.getElementById("descripcion_editar").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z0-9\s]$/, "descripcion_editar", "Solo se permiten letras y números.");
});

function validateCantidad() {
    const cantidad = document.getElementById("cantidad").value;
    const valor = parseFloat(cantidad);
    return !isNaN(valor) && valor > 0;
}

function validateDescripcion() {
    const descripcion = document.getElementById("descripcion").value;
    if (descripcion.length > 20) {
        showError("descripcion", "La descripción no debe superar los 20 caracteres.");
        return false;
    } else {
        clearError("descripcion");
        return true;
    }
}

function validateCantidadEditar() {
    const cantidad_editar = document.getElementById("cantidad_editar").value;
    const valor = parseFloat(cantidad_editar);
    return !isNaN(valor) && valor > 0;
}

function validateDescripcionEditar() {
    const descripcion_editar = document.getElementById("descripcion_editar").value;
    if (descripcion_editar.length > 20) {
        showError("descripcion_editar", "La descripción no debe superar los 20 caracteres.");
        return false;
    } else {
        clearError("descripcion_editar");
        return true;
    }
}
//Se valida de manera general
function enableSubmit_registrar() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateCantidad() &&
        validateDescripcion()&&
        document.getElementById("descripcion").value &&
        document.getElementById("cantidad").value;
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("registrar").disabled = !isFormValid;
}
document.getElementById("descripcion").addEventListener("input", enableSubmit_registrar);
document.getElementById("cantidad").addEventListener("input", enableSubmit_registrar);

function enableSubmit() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateCantidadEditar() &&
        validateDescripcionEditar()&&
        document.getElementById("descripcion_editar").value.trim() !== "" &&
        document.getElementById("cantidad_editar").value.trim() !== "";
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("modificar").disabled = !isFormValid;
}
document.getElementById("descripcion_editar").addEventListener("input", enableSubmit);
document.getElementById("cantidad_editar").addEventListener("input", enableSubmit);



