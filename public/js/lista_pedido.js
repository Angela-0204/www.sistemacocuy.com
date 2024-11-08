function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('es-ES', options).format(date);
}
function mostrar(id) {
    var datos = new FormData();
    datos.append("accion", "consultar");
    datos.append("id_pedido", id);
    AjaxEditar(datos);
}

function AjaxEditar(datos) {
    $.ajax({
        url: '',  // Cambia a la URL de tu controlador PHP
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        success: function(res) {
            var response = JSON.parse(res);   

            // Imprimir la respuesta en la consola para revisar su formato
            console.log(response);

            if (response.error) {
                alert("Error: " + response.error);
                return;
            }

            // Verifica si la respuesta tiene los datos esperados
            if (!response.pedido || !response.detalles) {
                alert("Datos incompletos en la respuesta.");
                return;
            }

            // Mostrar los datos del pedido en el modal
            var pedido = response.pedido;
            var detalles = response.detalles;
            var total = response.total;

            // Cargar los datos del pedido
            $("#modalPedido #codigoPedido").text('A-000'+pedido.id_pedido);
            $("#modalPedido #usuarioPedido").text(pedido.usuario);
            $("#modalPedido #clientePedido").text(pedido.nombre_cliente);
            $("#modalPedido #fechaPedido").text(formatDate(pedido.fecha_pedido));

            // Cargar los detalles del pedido
            var detallesHTML = '';
            detalles.forEach(function(detalle) {
                detallesHTML += `
                    <tr>
                        <td>${detalle.producto_nombre}</td>
                        <td>${detalle.producto_descripcion}</td>
                        <td>${detalle.nombre_categoria}</td>
                        <td>${detalle.empaquetado_descripcion}</td>
                        <td>${detalle.unidad_medida}</td>
                        <td>${detalle.precio_venta}</td>
                        <td>${detalle.cantidad}</td>
                        <td>${detalle.subtotal}</td>
                    </tr>
                `;
            });

            $("#modalPedido #detallePedido").html(detallesHTML);
            $("#modalPedido #totalPedido").text(total);

            // Mostrar el modal
            $("#modalPedido").modal("show");
        },
        error: function() {
            alert("Error al cargar los datos del pedido.");
        }
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



function funcionAjax(datos) {
    $.ajax({
        url: "",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (res) {
            if (res.estatus == 1) {
                Swal.fire({
                    icon: "success",
                    title: "Producto",
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
