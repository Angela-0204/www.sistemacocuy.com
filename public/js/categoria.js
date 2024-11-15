//Para registrar nueva categoria
$("#registrar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("nombre_categoria", $("input[name='nombre_categoria']").val());
    AjaxRegistrar(datos);
});

//Para modificar categoria
$("#modificar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("id_categoria", $("input[name='id']").val());
    datos.append("nombre_categoria", $("input[name='nombre_editar']").val());
    funcionAjax(datos);
});

function editar(id){
    var datos = new FormData();
    datos.append("accion", "consultar");
    datos.append("id_categoria", id);
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
                    title: "Categoria",
                    text: res.mensaje
                });
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar la categoria."
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
                    title: "Categoria",
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
            $("#id").val(res.id_categoria);
            $("#nombre_editar").val(res.nombre_categoria);
            $("#modal-edit-categoria").modal("show");   
        },
        error: function (err) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error en la solicitud."
            });
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
document.getElementById("nombre_categoria").addEventListener("keypress", function(event) {
    restrictInput(event, /^[a-zA-Z\s]*$/, "nombre_categoria", "Solo se permiten letras.");
});

document.getElementById("nombre_editar").addEventListener("keypress", function(event) {
    restrictInput(event, /^[a-zA-Z\s]*$/, "nombre_editar", "Solo se permiten letras.");
});

// Validaciones completas en `input`, sin mensajes de error
function validateNombre() {
    const nombre_categoria = document.getElementById("nombre_categoria").value;
    const nombreRegex = /^[a-zA-Z\s]{5,50}$/;
    if (!nombreRegex.test(nombre_categoria)) {
        showError("nombre_categoria", "El nombre debe tener entre 5 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("nombre_categoria");
        return true;
    }
}

// Validaciones completas en `input`, sin mensajes de error
function validateNombreEditar() {
    const nombre_editar = document.getElementById("nombre_editar").value;
    const nombreRegex = /^[a-zA-Z\s]{3,50}$/;
    if (!nombreRegex.test(nombre_editar)) {
        showError("nombre_editar", "El nombre debe tener entre 3 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("nombre_editar");
        return true;
    }
}

//Se valida de manera general
function enableSubmit_crear() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateNombre() &&
        document.getElementById("nombre_categoria").value.trim() !== "";
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("registrar").disabled = !isFormValid;
}

document.getElementById("nombre_categoria").addEventListener("input", enableSubmit_crear);

//Se valida de manera general
function enableSubmit() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateNombreEditar() &&
        document.getElementById("nombre_editar").value.trim() !== "";
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("modificar").disabled = !isFormValid;
}

document.getElementById("nombre_editar").addEventListener("input", enableSubmit);