//Para registrar nuevo usuario
$("#registrar").click(function (e) {
    e.preventDefault(); 
    var password = document.querySelector("input[name='password_user']").value;
    var passwordRepeat = document.querySelector("input[name='password_repeat']").value;
    if (password !== passwordRepeat) {
        mostrarError("Las contraseñas no coinciden.");
        return;
    }


    var email = document.querySelector("input[name='email']").value;

    // Expresión regular para validar el formato de email
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Validar el correo
    if (!emailRegex.test(email)) {
        mostrarError("Por favor, ingrese un email válido con un '@'.");
        return;
    }

    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("names", $("input[name='names']").val());
    datos.append("email", $("input[name='email']").val());
    datos.append("password_user", $("input[name='password_user']").val());
    datos.append("password_repeat", $("input[name='password_repeat']").val());
    datos.append("rol", $("select[name='roles']").val());
    AjaxRegistrar(datos);
});



//Para modificar usuario
$("#modificar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("id", $("input[name='id']").val());
    datos.append("names", $("input[name='names_edit']").val());
    datos.append("email", $("input[name='email_edit']").val());
    datos.append("password_user", $("input[name='password_user_edit']").val());
    datos.append("rol", $("select[name='roles_edit']").val());
    funcionAjax(datos);
});

function editar(id){
    var datos = new FormData();
    datos.append("accion", "consultar");
    datos.append("id_usuario", id);
    AjaxEditar(datos);
}

function mostrarError(mensaje){
    Swal.fire({
        icon: "error",
        title: "Error",
        text: mensaje
    });
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
                    title: "Usuario",
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
                    title: "Usuario",
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
            $("#id").val(res.id);
            $("#names_edit").val(res.names);
            $("#email_edit").val(res.email);
            $("#password_user_edit").val(res.password_user);
            $("#roles_edit").val(res.cod_tipo_usuario);
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

// Bloqueo de caracteres no permitidos en `keypress`, para validar en tiempo real
document.getElementById("names").addEventListener("keypress", function(event) {
    restrictInput(event, /^[a-zA-Z\s]*$/, "names", "Solo se permiten letras.");
});


document.getElementById("password_user").addEventListener("input", function() {
    const password = this.value;
    const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*.,])[A-Za-z\d!@#$%^&*.,]{8,}$/;
    if (!passwordRegex.test(password)) {
        showError("password_user", "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.");
    } else {
        clearError("password_user");
    }
});
document.getElementById("names_edit").addEventListener("keypress", function(event) {
    restrictInput(event, /^[a-zA-Z\s]*$/, "names_edit", "Solo se permiten letras.");
});


document.getElementById("password_user_edit").addEventListener("input", function() {
    const password_user_edit = this.value;
    const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*.,])[A-Za-z\d!@#$%^&*.,]{8,}$/;
    if (!passwordRegex.test(password_user_edit)) {
        showError("password_user_edit", "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.");
    } else {
        clearError("password_user_edit");
    }
});



// Validaciones completas en `input`, sin mensajes de error
function validatePassword() {
    const password_user = document.getElementById("password_user").value;
    const nombreRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*.,])[A-Za-z\d!@#$%^&*.,]{8,}$/;
    if (!nombreRegex.test(password_user)) {
        showError("password_user", "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial");
     
        return false;
    } else {
        clearError("password_user");
        return true;
    }
}

// Validaciones completas en `input`, sin mensajes de error
function validatePassword_edit() {
    const password_user_edit = document.getElementById("password_user_edit").value;
    const nombreRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*.,])[A-Za-z\d!@#$%^&*.,]{8,}$/;
    if (!nombreRegex.test(password_user_edit)) {
        showError("password_user_edit", "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial");
     
        return false;
    } else {
        clearError("password_user_edit");
        return true;
    }
}

// Validaciones completas en `input`, sin mensajes de error
function validateNombre() {
    const names = document.getElementById("names").value;
    const nombreRegex = /^[a-zA-Z\s]{2,50}$/;
    if (!nombreRegex.test(names)) {
        showError("names", "El nombre debe tener entre 2 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("names");
        return true;
    }
}

function validateNombreEditar() {
    const names_edit = document.getElementById("names_edit").value;
    const nombreRegex = /^[a-zA-Z\s]{2,50}$/;
    if (!nombreRegex.test(names_edit)) {
        showError("names_edit", "El nombre debe tener entre 2 y 50 caracteres y solo letras.");
        return false;
    } else {
        clearError("names_edit");
        return true;
    }
}


// Validación del correo
function validateEmail() {
    const email = document.getElementById("email").value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError("email", "Por favor, ingrese un email válido.");
        return false;
    } else {
        clearError("email");
        return true;
    }
}

function validateEmailEdit() {
    const email_edit = document.getElementById("email_edit").value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email_edit)) {
        showError("email_edit", "Por favor, ingrese un email válido.");
        return false;
    } else {
        clearError("email_edit");
        return true;
    }
}
// Verificación AJAX de existencia de correo
function checkEmailExists(email) {
    var datos = new FormData();
    datos.append("accion", "verificarCorreo");
    datos.append("email", email);

    $.ajax({
        url: "", // URL del archivo PHP actual
        type: "POST",
        data: datos,
        processData: false,
        contentType: false,
        success: function (response) {
            var res = JSON.parse(response);
            if (res.existe) {
                showError("email", "El correo ya está registrado.");
                document.getElementById("registrar").disabled = true;
            } else {
             
                enableSubmit(); // Habilita el botón si todo es válido
            }
        },
        error: function (err) {
            console.error("Error en la verificación del correo: ", err);
        }
    });
}



//Se valida de manera general
function enableSubmit_crear() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validatePassword() 
        validateNombre() 
        validateEmail() 
        checkEmailExists() 

        document.getElementById("password_user").value.trim() !== "" &&
        document.getElementById("names").value.trim() !== "" &&
        document.getElementById("email").value.trim() !== "";

        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("registrar").disabled = !isFormValid;
}

document.getElementById("names").addEventListener("input", enableSubmit_crear);
document.getElementById("password_user").addEventListener("input", enableSubmit_crear);



// Añade evento de validación en tiempo real para el email
document.getElementById("email").addEventListener("input", function() {
    validateEmail();
    checkEmailExists(this.value); // Verifica si el email ya está en uso
});




const togglePassword1 = document.getElementById('togglePassword1');
const passwordField1 = document.getElementById('password_user');
  

const togglePassword2 = document.getElementById('togglePassword2');
const passwordField2 = document.getElementById('password_repeat');

const togglePassword3 = document.getElementById('togglePassword3');
const passwordField3 = document.getElementById('password_user_edit');



// Alterna visibilidad para el primer campo
togglePassword1.addEventListener('click', function () {
  const type = passwordField1.getAttribute('type') === 'password' ? 'text' : 'password';
  passwordField1.setAttribute('type', type);
  this.classList.toggle('fa-eye-slash');
});

// Alterna visibilidad para el segundo campo
togglePassword2.addEventListener('click', function () {
  const type = passwordField2.getAttribute('type') === 'password' ? 'text' : 'password';
  passwordField2.setAttribute('type', type);
  this.classList.toggle('fa-eye-slash');
});






  function enableSubmit_editar() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
    validatePassword_edit() 
        validateNombreEditar() 
        validateEmailEdit() 
      
        document.getElementById("password_user_edit").value.trim() !== "" &&
        document.getElementById("names_edit").value.trim() !== "" &&
        document.getElementById("email_edit").value.trim() !== "";

        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("modificar").disabled = !isFormValid;
}

document.getElementById("names_edit").addEventListener("input", enableSubmit_editar);
document.getElementById("password_user_edit").addEventListener("input", enableSubmit_editar);


document.getElementById("email_edit").addEventListener("input", function() {
    validateEmailEdit();
  
});

togglePassword3.addEventListener('click', function () {
    const type = passwordField3.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField3.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
  });








