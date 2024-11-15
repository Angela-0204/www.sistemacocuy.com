//Para registrar nueva categoria
$("#registrar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("nombre_banco", $("input[name='nombre_banco']").val());
    datos.append("datos_banco", $("input[name='datos_banco']").val());
    datos.append("nombre",$("select[name='tipo_pago']").val());
        AjaxRegistrar(datos);
});

//Para modificar banco
$("#modificar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("id_banco", $("input[name='id']").val());
    datos.append("nombre_banco", $("input[name='nombre_editar']").val());
    datos.append("datos_banco", $("input[name='datos_editar']").val());
    datos.append("nombre", $("select[name='tipo_pago_edit']").val());
    funcionAjax(datos);
});

function editar(id){
    var datos = new FormData();
    datos.append("accion", "consultar");
    datos.append("id_banco", id);
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
                    title: "Banco",
                    text: res.mensaje
                });
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar el Banco."
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
                    title: "Banco",
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
            $("#id").val(res.id_banco);
            $("#nombre_editar").val(res.nombre_banco);
            $("#datos_editar").val(res.datos_banco);
            $("#tipo_pago_edit").val(res.id_tipo_pago);
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
document.getElementById("nombre_banco").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z\s]$/, "nombre_banco", "Solo se permiten letras.");
});
document.getElementById("nombre_editar").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z\s]$/, "nombre_editar", "Solo se permiten letras.");
});
document.getElementById("datos_banco").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "datos_banco", "Solo se permiten números.");
});

document.getElementById("datos_editar").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "datos_editar", "Solo se permiten números.");
});


// Validaciones completas en `input`, sin mensajes de error
function validateNombre() {
    const nombre_banco = document.getElementById("nombre_banco").value;
    const nombreRegex = /^[A-Za-z\s]{5,50}$/;
    if (!nombreRegex.test(nombre_banco)) {
        showError("nombre_banco", "El nombre debe tener entre 5 y 50 caracteres, solo letras.");
        return false;
    } else {
        clearError("nombre_banco");
        return true;
    }
}

function validateNombreEditar() {
    const nombre_editar = document.getElementById("nombre_editar").value;
    const nombreRegex = /^[A-Za-z\s]{5,50}$/;
    if (!nombreRegex.test(nombre_editar)) {
        showError("nombre_editar", "El nombre debe tener entre 5 y 50 caracteres, solo letras.");
        return false;
    } else {
        clearError("nombre_editar");
        return true;
    }
}
function validateDatos() {
    const datos_banco = document.getElementById("datos_banco").value;
    const valor = parseFloat(datos_banco);
    return !isNaN(valor) && valor > 0;
}
 
function validateDatosEditar() {
    const datos_editar = document.getElementById("datos_editar").value;
    const valor = parseFloat(datos_editar);
    return !isNaN(valor) && valor > 0;
}


function enableSubmit() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateNombre() &&
      
        validateDatos() &&
        
        document.getElementById("nombre_banco").value.trim() !== "" &&
  
        document.getElementById("datos_banco").value.trim() !== "";
       

        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("registrar").disabled = !isFormValid;
}

// Asignar eventos `input` para validar el formulario y habilitar el botón de guardar sin mostrar mensajes de error
document.getElementById("nombre_banco").addEventListener("input", enableSubmit);

document.getElementById("datos_banco").addEventListener("input", enableSubmit);


function enableSubmit_editar() {
    // Valida que ambas funciones de validación pasen y que los campos no estén vacíos
    const isFormValid =
        validateNombreEditar() &&
        validateDatosEditar() &&
        document.getElementById("nombre_editar").value.trim() !== "" &&
        document.getElementById("datos_editar").value.trim() !== "";

    // Habilita o deshabilita el botón de "modificar" según el resultado de `isFormValid`
    document.getElementById("modificar").disabled = !isFormValid;
}
document.getElementById("nombre_editar").addEventListener("input", enableSubmit_editar);
document.getElementById("datos_editar").addEventListener("input", enableSubmit_editar);