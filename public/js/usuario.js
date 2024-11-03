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
const togglePassword1 = document.getElementById('togglePassword1');
  const passwordField1 = document.getElementById('password_user');
  
  const togglePassword2 = document.getElementById('togglePassword2');
  const passwordField2 = document.getElementById('password_repeat');

  // Función para alternar la visibilidad de la contraseña
  togglePassword1.addEventListener('click', function () {
    const type = passwordField1.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField1.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash'); 
  });

  togglePassword2.addEventListener('click', function () {
    const type = passwordField2.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField2.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash'); 
  });














/*document.getElementById('registrar').addEventListener('click', function (e) {
    e.preventDefault();

    // Obtener los valores de los campos del formulario
    var names = document.querySelector("input[name='names']").value;
    var email = document.querySelector("input[name='email']").value;
    var password = document.querySelector("input[name='password_user']").value;
    var passwordRepeat = document.querySelector("input[name='password_repeat']").value;
    var rol = document.querySelector("select[name='roles']").value;

    // Validación
    if (!names || !email || !password || !passwordRepeat || !rol) {
        alert("Todos los campos son obligatorios.");
        return;
    }



    // Si todo está bien, enviar el formulario
    document.querySelector("form").submit();
});*/
//correo validacion
