$("#registrar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    datos.append("registrar", "true");
    datos.append("nombre", $("input[name='nombre']").val());
    datos.append("codigo", $("input[name='codigo']").val());
    datos.append("descripcion", $("input[name='descripcion']").val());
    datos.append("presentacion", $("select[name='presentacion']").val());
    datos.append("categoria", $("select[name='categoria']").val());
    datos.append("stock", $("input[name='stock']").val());
    datos.append("stock_minimo", $("input[name='stock_minimo']").val());
    datos.append("stock_maximo", $("input[name='stock_maximo']").val());
    datos.append("precio", $("input[name='precio']").val());
    datos.append("fecha", $("input[name='fecha']").val());
    datos.append("caja", $("select[name='caja']").val());
    datos.append("imagen", $("input[name='imagen']")[0].files[0]);

    AjaxRegistrar(datos);
});

$("#modificar").click(function (e) {
    e.preventDefault(); 
    var datos = new FormData();
    //Parametros(variable, valor)
    datos.append("modificar", "true");
    datos.append("id", $("input[name='id']").val());
    datos.append("nombre", $("input[name='nombre']").val());
    datos.append("codigo", $("input[name='codigo']").val());
    datos.append("descripcion", $("input[name='descripcion']").val());
    datos.append("categoria", $("select[name='categoria']").val());
    datos.append("almacen", $("select[name='nombre_almacen']").val());
    datos.append("stock_minimo", $("input[name='stock_minimo']").val());
    datos.append("stock_maximo", $("input[name='stock_maximo']").val());
    datos.append("precio", $("input[name='precio']").val());
    datos.append("imagen", $("input[name='imagen']")[0].files[0]);
    funcionAjax(datos);
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
                datos.append("eliminar", "true");
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
                    title: "Producto",
                    text: res.mensaje
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar el producto."
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
