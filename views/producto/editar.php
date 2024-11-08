<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Editar Producto</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header d-flex align-items-center">
              <div class="d-flex align-items-center">
                <h3 class="card-title mb-0">Modificar producto en inventario</h3>

              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="card-body">
              <div class="row">
              <div class="container">
                <h2>Editar Producto</h2>

                <!-- Formulario para datos principales del producto -->

                      <h6 style="color: red;">* Campos obligatorios</h6>
                          <h5>Datos Principales del Producto</h5>
                          <div class="row">
                              <div class="col-md-6 form-group">
                                  <label for="nombre">Nombre del producto <span class="required">*</span></label>
                                  <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($productoData['nombre']); ?>" placeholder="Escriba aquí el nombre del producto" maxlength="50">
                                  <span id="nombreError" class="text-danger"></span>
                              </div>
                              <div class="col-md-6 form-group">
                                  <label for="marca">Marca <span class="required">*</span></label>
                                  <select name="marca" id="marca" class="form-control">
                                      <?php foreach ($data_marcas as $marcas_dato) { ?>
                                          <option value="<?= $marcas_dato['id_presentacion']; ?>"><?= $marcas_dato['marca']; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12 form-group">
                                  <label for="descripcion">Descripción del producto</label>
                                  <input type="text" name="descripcion" id="descripcion" value="<?= htmlspecialchars($productoData['descripcion']); ?>"  class="form-control" placeholder="Escriba aquí una breve descripción del producto" maxlength="100">
                                  <span id="descripcionError" class="text-danger"></span>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6 form-group">
                                  <label for="categoria">Categoría del producto <span class="required">*</span></label>
                                  <select id="categoria" name="categoria" class="form-control">
                                    <?php foreach ($data_categorias as $categoria) { ?>
                                        <option value="<?= $categoria['id_categoria']; ?>" <?= $productoData['id_categoria'] == $categoria['id_categoria'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($categoria['nombre_categoria']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                              </div>
                              <div class="col-md-6 form-group">
                                  <label for="fecha">Fecha de expedición del producto <span class="required">*</span></label>
                                  <input type="date" name="fecha" class="form-control" value="<?= htmlspecialchars($productoData['fyh_creacion']); ?>" id="fecha">
                                  <span id="fechaError" class="text-danger"></span>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12 form-group mb-3">
                                  <label for="imagen">Agregar imagen del producto</label>
                                  <input class="form-control" name="imagen" type="file" id="imagen">
                                  <span id="imagenError" class="text-danger"></span>
                              </div>
                          </div>

                    <h3>Detalles del Inventario</h3>
                    <table id="detalleInventarioTable" class="table">
                        <thead>
                            <tr>
                                <th>Empaquetado</th>
                                <th>Stock</th>
                                <th>Lote</th>
                                <th>Precio Venta</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detallesInventario as $detalle) { ?>
                                <tr data-id-detalle="<?= htmlspecialchars($detalle['id_detalle_inventario']); ?>">
                                    <td><?= htmlspecialchars($detalle['empaquetado']); ?></td>
                                    <td contenteditable="true"><?= htmlspecialchars($detalle['stock']); ?></td>
                                    <td contenteditable="true"><?= htmlspecialchars($detalle['lote']); ?></td>
                                    <td contenteditable="true"><?= htmlspecialchars($detalle['precio_venta']); ?></td>
                                    <td>
                                        <select class="form-control">
                                            <option value="activo" <?= $detalle['estatus'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                            <option value="inactivo" <?= $detalle['estatus'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>

                    <button id="modificar" class="btn btn-primary">Guardar Cambios</button>
              </div>

              </div>

              <!-- Modal para agregar Detalle de Inventario -->
              <div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="detalleModalLabel">Agregar Detalle de Inventario</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form id="detalleForm">
                                  <div class="form-group">
                                      <label for="empaquetado">Empaquetado <span class="required">*</span></label>
                                      <select name="empaquetado" id="empaquetado" class="form-control">
                                          <?php foreach ($data_cajas as $cajas) { ?>
                                              <option value="<?= $cajas['id_empaquetado']; ?>"><?= $cajas['cantidad']; ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="stock">Cantidad de productos</label>
                                      <input type="number" name="stock" id="stock" class="form-control" placeholder="Escriba aquí la cantidad en cajas del producto">
                                      <span id="stockError" class="text-danger"></span>

                                  </div>
                                  <div class="form-group">
                                      <label for="lote">Lote <span class="required">*</span></label>
                                      <input type="text" name="lote" id="lote" class="form-control" placeholder="Escriba aquí el lote del producto">
                                      <span id="loteError" class="text-danger"></span>

                                  </div>
                                  <div class="form-group">
                                      <label for="precio">Precio por caja del producto <span class="required">*</span></label>
                                      <input type="number" step="0.01" name="precio" id="precio" class="form-control" placeholder="Escriba aquí el precio del producto por caja">
                                      <span id="precioError" class="text-danger"></span>

                                  </div>
                                  <div class="form-group">
                                      <label for="estatus">Estatus <span class="required">*</span></label>
                                      <select name="estatus" id="estatus" class="form-control">
                                          <option value="activo">Activo</option>
                                          <option value="inactivo">Inactivo</option>
                                      </select>
                                  </div>
                                  <button type="button" onclick="guardarDetalle()" class="btn btn-primary">Guardar Detalle</button>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>


            </div>

          </div>

        </div>
      </div>
    </div>

    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('views/layout/footer.php'); ?>
<script>

$("#modificar").click(function (e) {
    e.preventDefault();

    var datos = new FormData();
    datos.append("accion", "modificar");
    datos.append("nombre", $("input[name='nombre']").val());
    datos.append("descripcion", $("input[name='descripcion']").val());
    datos.append("categoria", $("select[name='categoria']").val());
    datos.append("marca", $("select[name='marca']").val());
    datos.append("fecha", $("input[name='fecha']").val());
    datos.append("imagen", $("input[name='imagen']")[0].files[0]);

    $("#detalleInventarioTable tbody tr").each(function (index, row) {
        let idDetalle = $(row).data("id-detalle"); // Obtienes el id_detalle_inventario
        let empaquetadoId = $(row).find("td[data-empaquetado-id]").data("empaquetado-id");
        let stock = $(row).find("td:eq(1)").text().trim();
        let lote = $(row).find("td:eq(2)").text().trim();
        let precio = $(row).find("td:eq(3)").text().trim();
        let estatus = $(row).find("td:eq(4) select").val();

        datos.append(`detalles[${index}][id_detalle_inventario]`, idDetalle); // Incluye el id_detalle_inventario
        datos.append(`detalles[${index}][empaquetado]`, empaquetadoId);
        datos.append(`detalles[${index}][stock]`, stock);
        datos.append(`detalles[${index}][lote]`, lote);
        datos.append(`detalles[${index}][precio]`, precio);
        datos.append(`detalles[${index}][estatus]`, estatus);
    });

    console.log("Datos enviados:", datos); // Imprime en consola para revisar

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
        error: function(xhr, status, error) {
            console.error("Error en la solicitud:", error);
            console.log(xhr.responseText); // Mostrar la respuesta del servidor
        }
    });
}
</script>