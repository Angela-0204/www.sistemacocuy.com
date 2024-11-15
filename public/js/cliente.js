//Para registrar nuevo usuario
$("#registrar").click(function (e) {
   e.preventDefault(); 
    var email = document.querySelector("input[name='correo']").value;

    // Expresión regular para validar el formato de email
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Validar el correo
    if (!emailRegex.test(email)) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Por favor, ingrese un email válido con un '@'."
        });

    }
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("cedula_rif", $("input[name='cedula_rif']").val());
    datos.append("nombre_cliente", $("input[name='nombre_cliente']").val());
    datos.append("apellido", $("input[name='apellido']").val());
    datos.append("correo", $("input[name='correo']").val());
    datos.append("direccion", $("input[name='direccion']").val());
    datos.append("telefono", $("input[name='telefono']").val());
    datos.append("operadora", $("select[name='operadora']").val());
    datos.append("estatus", $("select[name='estatus']").val());
    
    AjaxRegistrar(datos);
});
function editar_prueba(cedula_rif){
    var datos = new FormData();
    
    datos.append("accion", "consultar");
    datos.append("cedula_rif", cedula_rif);
    AjaxEditar(datos);
}


//Para modificar usuario
$("#modificar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("cedula_rif", $("input[name='cedula_rif_editar']").val());
    datos.append("nombre_cliente", $("input[name='nombre_cliente_edit']").val());
    datos.append("apellido", $("input[name='apellido_edit']").val());
    datos.append("correo", $("input[name='email_edit']").val());
    datos.append("direccion", $("input[name='direccion_edit']").val());
    datos.append("telefono", $("input[name='telefono_edit']").val());
    datos.append("operadora", $("select[name='operadora_edit']").val());
    datos.append("estatus", $("select[name='estatus_edit']").val());
    funcionAjax(datos);
});




//Para eliminar un registro
function eliminar(cod_cliente) {
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
                datos.append("cod_cliente", cod_cliente);
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
            try {
                var res = JSON.parse(response);
                if (res.estatus == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Cliente",
                        text: res.mensaje
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.mensaje || "Error desconocido al registrar el cliente."
                    });
                }
            } catch (error) {
                console.error("Error al parsear la respuesta JSON:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La respuesta del servidor no es válida."
                });
            }
        },
        error: function (err) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error en la solicitud al servidor."
            });
            console.error("Error en la solicitud AJAX:", err);
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
                    title: "Cliente",
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
            var telefonoCompleto = res.telefono;
    
            // Obtener los primeros 4 dígitos (operadora)
            var operadora = telefonoCompleto.substring(0, 4);
            
            // Obtener los últimos 7 dígitos (número de teléfono)
            var telefono = telefonoCompleto.substring(5); 
            $("#cedula_rif_editar").val(res.cedula_rif);
            $("#nombre_cliente_edit").val(res.nombre_cliente);
            $("#apellido_edit").val(res.apellido);
            $("#email_edit").val(res.correo);
            $("#direccion_edit").val(res.direccion);
            $("#operadora_edit").val(operadora);
            $("#telefono_edit").val(telefono);
            $("#estatus_edit").val(res.estatus);
            $("#modal-edit-users").modal("show");   
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
document.getElementById("cedula_rif").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "cedula_rif", "Solo se permiten números.");
});
document.getElementById("nombre_cliente").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z0-9\s]$/, "nombre_cliente", "Solo se permiten letras.");
});
// para la model de modidficar el nombre
document.getElementById("nombre_cliente_edit").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z0-9\s]$/, "nombre_cliente_edit", "Solo se permiten letras.");
});

document.getElementById("apellido").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z\s]$/, "apellido", "Solo se permiten letras.");
});
// para la model de modidficar el apellido

document.getElementById("apellido_edit").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z\s]$/, "apellido_edit", "Solo se permiten letras.");
});


document.getElementById("correo").addEventListener("input", function() {
    const correo = this.value;
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!correoRegex.test(correo)) {
        showError("correo", "El correo debe incluir una direccion como @gmail.com, @hotmail.com, @yahoo.com, @outlook.com.");
    } else {
        clearError("correo");
    }
});
// para editar correo 
document.getElementById("email_edit").addEventListener("input", function() {
    const email_edit = this.value;
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!correoRegex.test(email_edit)) {
        showError("email_edit", "El correo debe incluir una direccion como @gmail.com, @hotmail.com, @yahoo.com, @outlook.com.");
    } else {
        clearError("email_edit");
    }
});

document.getElementById("direccion").addEventListener("input", function() {
    const direccion = this.value;
    const direccionRegex = /^[A-Za-z0-9#\-\.\s]+$/;
    if (!direccionRegex.test(direccion)) {
        showError("direccion", "Solo se aceptan numeros, letras, espacios, # y -.");
    } else {
        clearError("direccion");
    }
});
// para editar direccion
document.getElementById("direccion_edit").addEventListener("input", function() {
    const direccion_edit = this.value;
    const direccionRegex = /^[A-Za-z0-9#\-\.\s]+$/;
    if (!direccionRegex.test(direccion_edit)) {
        showError("direccion_edit", "Solo se aceptan numeros, letras, espacios, # y -.");
    } else {
        clearError("direccion_edit");
    }
});


document.getElementById("telefono").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "telefono", "Solo se permiten números.");
});
 //para editar telefono
document.getElementById("telefono_edit").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "telefono_edit", "Solo se permiten números.");
});


function validateNombre() {
    const nombre_cliente = document.getElementById("nombre_cliente").value;
    const nombreRegex = /^[A-Za-z\s]{5,50}$/;
    if (!nombreRegex.test(nombre_cliente)) {
        showError("nombre_cliente", "El nombre debe tener entre 5 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("nombre_cliente");
        return true;
    }
} 

function validateNombreEdit() {
    const nombre_cliente_edit = document.getElementById("nombre_cliente_edit").value;
    const nombreRegex = /^[A-Za-z\s]{5,50}$/;
    if (!nombreRegex.test(nombre_cliente_edit)) {
        showError("nombre_cliente_edit", "El nombre debe tener entre 5 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("nombre_cliente_edit");
        return true;
    }
} 


function validateApellido() {
    const apellido = document.getElementById("apellido").value;
    const nombreRegex = /^[A-Za-z\s]{5,50}$/;
    if (!nombreRegex.test(apellido)) {
        showError("apellido", "El apellido debe tener entre 5 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("apellido");
        return true;
    }
}

function validateApellidoEdit() {
    const apellido_edit = document.getElementById("apellido_edit").value;
    const nombreRegex = /^[A-Za-z\s]{5,50}$/;
    if (!nombreRegex.test(apellido_edit)) {
        showError("apellido_edit", "El apellido debe tener entre 5 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("apellido_edit");
        return true;
    }
}

function validateCorreo() {
    const correo = document.getElementById("correo").value;
    const nombreRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!nombreRegex.test(correo)) {
        showError("correo", "El correo debe incluir una direccion como @gmail.com, @hotmail.com, @yahoo.com, @outlook.com");
     
        return false;
    } else {
        clearError("correo");
        return true;
    }
} 

function validateCorreoEdit() {
    const email_edit = document.getElementById("email_edit").value;
    const nombreRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!nombreRegex.test(email_edit)) {
        showError("email_edit", "El correo debe incluir una direccion como @gmail.com, @hotmail.com, @yahoo.com, @outlook.com");
     
        return false;
    } else {
        clearError("email_edit");
        return true;
    }
}

function validateDireccion() {
    const direccion = document.getElementById("direccion").value;
    const nombreRegex = /^[A-Za-z0-9#\-\.\,\s]+$/ ;
    if (!nombreRegex.test(direccion)) {
        showError("direccion", "Ingrese su direccion.");
     
        return false;
    } else {
        clearError("direccion");
        return true;
    }
}

function validateDireccionEdit() {
    const direccion_edit = document.getElementById("direccion_edit").value;
    const nombreRegex = /^[A-Za-z0-9#\-\.\,\s]+$/ ;
    if (!nombreRegex.test(direccion_edit)) {
        showError("direccion_edit", "Ingrese su direccion.");
     
        return false;
    } else {
        clearError("direccion_edit");
        return true;
    }
}

function validateCedula_rif() {
    const cedula_rif = document.getElementById("cedula_rif").value;
    const valor = parseFloat(cedula_rif);
    return !isNaN(valor) && valor > 0;
}

function validateTelefono() {
    const telefono= document.getElementById("telefono").value;
    const valor = parseFloat(telefono);
    return !isNaN(valor) && valor > 0;
}

function validateTelefonoEdit() {
    const telefono_edit= document.getElementById("telefono_edit").value;
    const valor = parseFloat(telefono_edit);
    return !isNaN(valor) && valor > 0;
}



function enableSubmit_crear() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
       
        validateCedula_rif() &&
        validateNombre()&&
       
        validateApellido() &&
       
        validateCorreo()  &&
       
        validateDireccion() &&
  
        validateTelefono() &&    
        document.getElementById("cedula_rif").value.trim() !== "" &&//Y aqui se validan que realmente tengan un valor estos campos
        document.getElementById("nombre_cliente").value.trim() !== "" &&    
        document.getElementById("correo").value.trim() !== "" &&   
        document.getElementById("apellido").value.trim() !== "" &&      
        document.getElementById("direccion").value.trim() !== "" &&   
        document.getElementById("telefono").value.trim() !== "";       
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("registrar").disabled = !isFormValid;
}

document.getElementById("cedula_rif").addEventListener("input", enableSubmit_crear);
document.getElementById("apellido").addEventListener("input", enableSubmit_crear);

document.getElementById("nombre_cliente").addEventListener("input", enableSubmit_crear);

document.getElementById("correo").addEventListener("input", enableSubmit_crear);

document.getElementById("direccion").addEventListener("input", enableSubmit_crear);

document.getElementById("telefono").addEventListener("input", enableSubmit_crear);


function enableSubmit() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
       
        validateNombreEdit () &&
        validateApellidoEdit () &&
        validateCorreoEdit &&
        validateDireccionEdit () &&
        validateTelefonoEdit () &&
    
      
        document.getElementById("nombre_cliente_edit").value.trim() !== "" &&
       
        document.getElementById("email_edit").value.trim() !== "" &&
    
        document.getElementById("apellido_edit").value.trim() !== "" &&
    
        document.getElementById("direccion_edit").value.trim() !== "" &&
  
        document.getElementById("telefono_edit").value.trim() !== "";
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("modificar").disabled = !isFormValid;
}

document.getElementById("apellido_edit").addEventListener("input", enableSubmit);

document.getElementById("nombre_cliente_edit").addEventListener("input", enableSubmit);

document.getElementById("email_edit").addEventListener("input", enableSubmit);

document.getElementById("direccion_edit").addEventListener("input", enableSubmit);

document.getElementById("telefono_edit").addEventListener("input", enableSubmit);