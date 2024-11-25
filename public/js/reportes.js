const selectTipoReporte = document.getElementById('tipo-reporte');
  const fechasDivs = document.querySelectorAll('.fechas');
  const generalDiv = document.querySelector('.general');
  const rangoDiv = document.querySelector('.rango');

  // Evento para detectar el cambio en el select
  selectTipoReporte.addEventListener('change', function () {
    if (this.value === '2') {
      // Mostrar los elementos con clase 'fechas' y 'rango', ocultar 'general'
      fechasDivs.forEach(div => {
        div.style.display = 'block';
      });
      rangoDiv.style.display = 'block';
      generalDiv.style.display = 'none';
    } else {
      // Ocultar los elementos con clase 'fechas' y 'rango', mostrar 'general'
      fechasDivs.forEach(div => {
        div.style.display = 'none';
      });
      rangoDiv.style.display = 'none';
      generalDiv.style.display = 'block';
    }
  });

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

function generarInventarioGeneral(reporte) {
    $.ajax({
        url: "", 
        type: "GET",
        data: { reporte: reporte},
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


function generarInventarioFecha(reporte) {
    // Obtener los valores de las fechas
    var fecha_desde = $("input[name='fecha_desde_inventario']").val();
    var fecha_hasta = $("input[name='fecha_hasta_inventario']").val();

    // Validaciones
    if (!fecha_desde || !fecha_hasta) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ambas fechas deben estar seleccionadas."
        });
        return; // Detener ejecución si no hay fechas
    }

    if (fecha_hasta < fecha_desde) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "La fecha hasta no puede ser menor que la fecha desde."
        });
        return; // Detener ejecución si las fechas no son válidas
    }

    // Si las validaciones pasan, proceder con la solicitud AJAX
    $.ajax({
        url: "", 
        type: "GET",
        data: { reporte: reporte, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta },
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


