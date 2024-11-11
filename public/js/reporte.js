document.getElementById('nombre_metodo').addEventListener('change', function() {
    var tipoPagoId = this.value;
    consultarBancos(tipoPagoId);
});

document.getElementById('pedido').addEventListener('change', function() {
    var id_pedido = this.value;
    var datos = new FormData();
    datos.append("accion", "mostrar_monto");
    datos.append("id_pedido", id_pedido);
    MostrarMonto(datos);
});
function consultarBancos(id){
    var datos = new FormData();
    datos.append("accion", "listar_bancos");
    datos.append("id_tipo_pago", id);
    AjaxBancos(datos);
}

function AjaxBancos(datos) {
    $.ajax({
        url: "",  // Cambia a la ruta real de tu controlador
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (response) {
            // Aquí procesamos la respuesta y actualizamos el select de bancos
            var bancos = JSON.parse(response);
            var bancoSelect = document.getElementById('banco');
            bancoSelect.innerHTML = ""; // Limpiar las opciones actuales

            bancos.forEach(function(banco) {
                var option = document.createElement('option');
                option.value = banco.id_banco;
                option.textContent = banco.nombre_banco;
                bancoSelect.appendChild(option);
            });
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

function MostrarMonto(datos) {
    $.ajax({
        url: "", // Cambia esta ruta por la de tu controlador
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (response) {
            var data = JSON.parse(response);
            var montoPagar = document.getElementById('monto-pagar');
            
            if (data && typeof data.monto_pendiente !== "undefined") {
                // Si hay un monto pendiente, mostramos la cantidad
                if (data.monto_pendiente > 0) {
                    montoPagar.textContent = "Monto pendiente: $" + data.monto_pendiente;
                    montoPagar.style.color = "black"; // Monto pendiente en color normal
                } else {
                    montoPagar.textContent = "Monto $" + data.monto_total_pedido +" pagado en su totalidad";
                    montoPagar.style.color = "grren"; // Texto en rojo si el monto está completamente pagado
                }
            } else {
                // Si no hay datos, mostramos un mensaje de error
                montoPagar.textContent = "No se pudo obtener el monto.";
                montoPagar.style.color = "red";
            }
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

//Para registrar nueva reporte
$("#registrar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("accion", "registrar");
    datos.append("id_tipo_pago", $("select[name='nombre_metodo']").val());
    datos.append("id_banco", $("select[name='banco']").val());
    datos.append("id_pedidp", $("select[name='pedido']").val());
    datos.append("referencia", $("input[name='referencia']").val());
    datos.append("monto", $("input[name='monto']").val());
    datos.append("fyh_pago", $("input[name='fecha']").val());
    AjaxRegistrar(datos);
});




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
                    title: "Pago",
                    text: res.mensaje
                });
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar el pago."
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
                    title: "Pago",
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

// Bloqueo de caracteres no permitidos en keypress, para validar en tiempo real
document.getElementById("referencia").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "referencia", "Solo se permiten números.");
});

document.getElementById("monto").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "monto", "Solo se permiten números.");
});

document.getElementById("referencia_editar").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "referencia_editar", "Solo se permiten números.");
});

document.getElementById("monto_editar").addEventListener("keypress", function(event) {
    restrictInput(event, /^[0-9]$/, "monto_editar", "Solo se permiten números.");
});

function validateReferencia() {
    const referencia = document.getElementById("referencia").value;
    const valor = parseFloat(referencia);
    return !isNaN(valor) && valor > 0;
}
function validateMonto() {
    const monto = document.getElementById("monto").value;
    const valor = parseFloat(monto);
    return !isNaN(valor) && valor > 0;
}

//Se valida de manera general
function enableSubmit() {
    //Se validan en funciones que cumplan todas con las exp reg
    const isFormValid =
        validateReferencia() &&
        validateMonto() &&
        document.getElementById("referencia").value &&
        document.getElementById("monto").value;
        // Habilita o deshabilita el botón de "registrar" según el resultado de isFormValid
        document.getElementById("registrar").disabled = !isFormValid;
}

document.getElementById("referencia").addEventListener("input", enableSubmit);
document.getElementById("monto").addEventListener("input", enableSubmit);