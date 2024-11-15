//Para registrar nueva marca
$("#registrar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("marca", $("input[name='marca']").val());
    datos.append("medida", $("select[name='mililitro']").val());

    AjaxRegistrar(datos);
});

//Para modificar marca
$("#modificar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("id_presentacion", $("input[name='id']").val());
    datos.append("marca", $("input[name='nombre_editar']").val());
    datos.append("medida", $("select[name='unidad_medida']").val());

    funcionAjax(datos);
});

function editar(id){
    var datos = new FormData();
    datos.append("accion", "consultar");
    datos.append("id_presentacion", id);    
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
                    title: "Marca",
                    text: res.mensaje
                });
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar la Marca."
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
                    title: "Marca",
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
            $("#id").val(res.id_presentacion);
            $("#nombre_editar").val(res.marca);
            $("#unidad_medida").val(res.medida);

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
document.getElementById("nombre_marca").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z0-9\s]$/, "nombre_marca", "Solo se permiten letras y números.");
});
//editar nombre 
document.getElementById("nombre_editar").addEventListener("keypress", function(event) {
    restrictInput(event, /^[A-Za-z0-9\s]$/, "nombre_editar", "Solo se permiten letras y números.");
});


// Validaciones completas en `input`, sin mensajes de error
function validateNombre() {
    const nombre_marca = document.getElementById("nombre_marca").value;
    const nombreRegex = /^[A-Za-z0-9\s]{2,50}$/;
    if (!nombreRegex.test(nombre_marca)) {
        showError("nombre_marca", "El nombre de la marca debe tener entre 2 y 50 caracteres, solo letras y números.");
        return false;
    } else {
        clearError("nombre_marca");
        return true;
    }
}
function validateNombreEditar() {
    const nombre_editar = document.getElementById("nombre_editar").value;
    const nombreRegex = /^[A-Za-z0-9\s]{2,50}$/;
    if (!nombreRegex.test(nombre_editar)) {
        showError("nombre_editar", "El nombre de la marca debe tener entre 2 y 50 caracteres, solo letras y números.");
        return false;
    } else {
        clearError("nombre_editar");
        return true;
    }
}
function enableSubmit_crear() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateNombre()
     
        document.getElementById("nombre_marca").value.trim() !== "";
      
      
        // Habilita o deshabilita el botón de "registrar" según el resultado de `isFormValid`
        document.getElementById("registrar").disabled = !isFormValid;
        
}
document.getElementById("nombre_marca").addEventListener("input", enableSubmit_crear);


function enableSubmit_editar() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =

        validateNombreEditar () &&
     
        document.getElementById("nombre_editar").value.trim() !== "";
    
        document.getElementById("modificar").disabled = !isFormValid;
}
document.getElementById("nombre_editar").addEventListener("input", enableSubmit_editar);