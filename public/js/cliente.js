//Para registrar nuevo usuario
$("#registrar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("cedula_rif", $("input[name='cedula_rif']").val());
    datos.append("nombre_cliente", $("input[name='nombre_cliente']").val());
    datos.append("apellido", $("input[name='apellido']").val());
    datos.append("correo", $("input[name='correo']").val());
    datos.append("direccion", $("input[name='direccion']").val());
    datos.append("telefono", $("input[name='telefono']").val());
    datos.append("estatus", $("input[name='estatus']").val());
    
    AjaxRegistrar(datos);
});



//Para modificar usuario
$("#modificar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("cedula_rif", $("input[name='cedula_rif_editar']").val());
    datos.append("nombre_cliente", $("input[name='nombre_cliente_edit']").val());
    datos.append("apellido", $("input[name='apellido_edit']").val());
    datos.append("correo", $("input[name='email_edit']").val());
    datos.append("direccion", $("select[name='direccion_edit']").val());
    datos.append("telefono", $("select[name='telefono_edit']").val());
    datos.append("estatus", $("select[name='estatus_edit']").val());
   
    funcionAjax(datos);
});

function editar(cedula_rif){
    var datos = new FormData();
    datos.append("accion", "consultar");
    datos.append("cedula_rif", cedula_rif);
    AjaxEditar(datos);
}


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
                console.error("Respuesta recibida:", response);
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
          
            $("#cedula_rif_editar").val(res.cedula_rif);
            $("#nombre_cliente_edit").val(res.nombre_cliente);
            $("#apellido_edit").val(res.apellido);
            $("#email_edit").val(res.correo);
            $("#direccion_edit").val(res.direccion);
            $("#telefono_edit").val(res.telefono);
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

document.getElementById('registrar').addEventListener('click', function (e) {
    e.preventDefault();

    // Obtener los valores de los campos del formulario
    var cedula_rif = document.querySelector("input[name='cedula_rif']").value;
    var nombre_cliente = document.querySelector("input[name='nombre_cliente']").value;
    var apellido = document.querySelector("input[name='apellido']").value;
    var correo = document.querySelector("input[name='correo']").value;
    var direccion = document.querySelector("select[name='direccion']").value;
    var telefono = document.querySelector("select[name='telefono']").value;
    var estatus = document.querySelector("select[name='estatus']").value;

    // Validación
    if (!cedula_rif || !nombre_cliente || !apellido|| !correo|| !direccion|| !telefono|| !estatus) {
        alert("Todos los campos son obligatorios.");
        return;
    }

    // Si todo está bien, enviar el formulario
    document.querySelector("form").submit();
});
//correo validacion

document.getElementById('registrar').addEventListener('click', function (e) {
    e.preventDefault();

    // Obtener el valor del campo de correo electrónico
    var email = document.querySelector("input[name='correo']").value;

    // Expresión regular para validar el formato de email
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Validar el correo
    if (!emailRegex.test(email)) {
        alert("Por favor, ingrese un email válido con un '@'.");
        return;
    }

    // Continuar con el envío del formulario si el email es válido
    document.querySelector("form").submit();
});
