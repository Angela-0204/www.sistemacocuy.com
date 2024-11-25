function detalles(id){
    var datos = new FormData();
    datos.append("accion", "detalles");
    datos.append("id_producto", id);
    AjaxDetalles(datos);
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



function AjaxDetalles(datos) {
    $.ajax({
        url: "", // Cambia esto a la URL que procesa el caso "detalles"
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (response) {
            var res = JSON.parse(response);

            // Limpiar el contenido previo de la tabla
            $('#tablaDetallesInventario').empty();

            // Recorrer cada registro y agregarlo a la tabla
            res.forEach(item => {
                $('#tablaDetallesInventario').append(`
                    <tr>
                      <td>${item.empaquetado}</td>
                      <td>${item.stock}</td>
                      <td>${item.lote}</td>
                         <td>${item.medida}</td>
                      <td>${item.precio_venta}$</td>
                    </tr>
                `);
            });

            // Mostrar el modal
            $('#modalDetallesInventario').modal('show');
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

