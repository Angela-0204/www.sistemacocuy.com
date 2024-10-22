//Para registrar nuevo usuario

$("#registrar").click(function (e) {
    e.preventDefault(); 
    var nombres = $("input[name='names']").val();
    var email = $("input[name='email']").val();
    var password_user = $("input[name='password_user']").val();
    var password_repeat = $("input[name='password_repeat']").val();
    var id_rol = $("select[name='id_rol']").val();

    // Verificar si algún campo requerido está vacío
    if (nombres === "" || email === "" || password_user === "" || password_repeat === "" || id_rol === "") {
        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Por favor, complete todos los campos requeridos."
        });
        return; // Detener el proceso si algún campo está vacío
    }

    // Verificar que las contraseñas coincidan
    if (password_user !== password_repeat) {
        Swal.fire({
            icon: "error",
            title: "Error de contraseña",
            text: "Las contraseñas no coinciden. Intente de nuevo."
        });
        return; // Detener el proceso si las contraseñas no coinciden
    }

    // Si todos los campos están llenos, continuar con el registro
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("names", nombres);
    datos.append("email", email);
    datos.append("password_user", password_user);
    datos.append("password_repeat", password_repeat);
    datos.append("id_rol", id_rol);

    AjaxRegistrar(datos); // Llamar a la función que ejecuta la solicitud AJAX
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
    datos.append("id_rol", $("select[name='id_rol']").val());
    funcionAjax(datos);
});

function editar(id){
    var datos = new FormData();
    datos.append("accion", "consultar");
    datos.append("id_usuario", id);
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