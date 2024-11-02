function generar(reporte) {
    $.ajax({
        url: "", 
        type: "GET",
        data: { reporte: reporte },
        success: function(response) {
            var res = JSON.parse(response);
            if (res.estatus == 1) {
                // Abrir el PDF en una nueva pestaña
                window.open(res.url, '_blank');
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: res.mensaje
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error en la solicitud."
            });
        }
    });
}
