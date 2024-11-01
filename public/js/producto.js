$("#registrar").click(function (e) {
    e.preventDefault();
    var datos = new FormData();
    datos.append("accion", "registrar"); // Cambiado aquí
    datos.append("nombre", $("input[name='nombre']").val());
    datos.append("descripcion", $("input[name='descripcion']").val());
    datos.append("marca", $("select[name='marca']").val());
    datos.append("categoria", $("select[name='categoria']").val());
    datos.append("stock", $("input[name='stock']").val());
    datos.append("precio", $("input[name='precio']").val());
    datos.append("fecha", $("input[name='fecha']").val());
    datos.append("caja", $("select[name='caja']").val());
    datos.append("lote", $("select[name='lote']").val());
    datos.append("estatus", $("select[name='estatus']").val());
    datos.append("imagen", $("input[name='imagen']")[0].files[0]);

    AjaxRegistrar(datos);
});

function AjaxRegistrar(datos) {
    $.ajax({
        url: "",  // Vacío, porque estamos en el mismo archivo
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (res) {
            try {

                if (res.estatus == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Producto",
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
            } catch (error) {
                console.error("Error al parsear JSON:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error en la respuesta del servidor."
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
