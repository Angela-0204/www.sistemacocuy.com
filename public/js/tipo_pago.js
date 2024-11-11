
$("#registrar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("nombre", $("input[name='nombre']").val());
   
    AjaxRegistrar(datos);
});


$("#modificar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("id_tipo_pago", $("input[name='id']").val());
    datos.append("nombre", $("input[name='nombre_editar']").val());
   
    funcionAjax(datos);
});

function editar(id){
    var datos = new FormData();
    datos.append("accion", "consultar");
    datos.append("id_tipo_pago", id);

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
                    title: "Tipo de Pago",
                    text: res.mensaje
                });
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar el tipo de pago."
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
                    title: "Tipo de Pago",
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
            $("#id").val(res.id_tipo_pago);
            $("#nombre_editar").val(res.nombre);
            $("#modal-edit-categoria").modal("show");   
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

$("#nombre_tipo").on("input", function () {
    var nombre = $(this).val();
    var datos = new FormData();
    datos.append("accion", "verificarNombre");
    datos.append("nombre", nombre);

    $.ajax({
        url: "", // Mismo URL que los otros llamados AJAX
        type: "POST",
        data: datos,
        processData: false,
        contentType: false,
        success: function (response) {
            var res = JSON.parse(response);
            if (res.existe) {
                showError("nombre_tipo", "El tipo de pago ya existe.");
                document.getElementById("registrar").disabled = true;
            } else {
                clearError("nombre_tipo");
                enableSubmit(); // Rehabilita el botón si el formulario es válido
            }
        }
    });
});






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
document.getElementById("nombre_tipo").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z\s]$/, "nombre_tipo", "Solo se permiten letras.");
});

document.getElementById("nombre_editar").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z\s]$/, "nombre_editar", "Solo se permiten letras.");
});
// Validaciones completas en `input`, sin mensajes de error
function validateNombre() {
    const nombre_tipo = document.getElementById("nombre_tipo").value;
    const nombreRegex = /^[A-Za-z\s]{5,50}$/;
    if (!nombreRegex.test(nombre_tipo)) {
        showError("nombre_tipo", "El nombre del tipo de pago debe tener entre 5 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("nombre_tipo");
        return true;
    }
}
function validateNombreEditar() {
    const nombre_editar = document.getElementById("nombre_editar").value;
    const nombreRegex = /^[A-Za-z\s]{5,50}$/;
    if (!nombreRegex.test(nombre_editar)) {
        showError("nombre_editar", "El nombre del pago de pago debe tener entre 5 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("nombre_editar");
        return true;
    }
}
function enableSubmit() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateNombre()&&
        document.getElementById("nombre_tipo").value;
      
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("registrar").disabled = !isFormValid;
}
document.getElementById("nombre_tipo").addEventListener("input", enableSubmit);

function enableSubmit() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateNombreEditar()&&
        document.getElementById("nombre_editar").value.trim() !== "";
      
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("modificar").disabled = !isFormValid;
}
document.getElementById("nombre_editar").addEventListener("input", enableSubmit);