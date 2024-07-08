<?php include('views/layout/menu_usuario.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Agregar Producto</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <h1>Punto de Venta</h1>
      <div>
        <div class="col-md-10 form-group">
          <label for="">Producto</label>
          <input type="text" name="nombre" class="form-control" placeholder="Escriba aquí el nombre del producto">
        </div>
      </div>

      <div class="content">
    <div class="container-fluid">

    <div class="row">
        <div class="col-md-6">
          <div class="card card-outline card-primary">
            <div class="card-header ">
              <h3 class="card-title mb-0">Total Venta: S./ ---- </h3>
              <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-categoria">Concretar Venta</button>
              <button type="button" class="btn btn-danger ml-3" data-toggle="modal" data-target="#modal-add-categoria">Vaciar Lista</button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>

            </div>
            <div class="card-body">
              <table id="examplel" class="table table-bordered table-atriped">
                <thead>
                  <tr>
                    <th>
                      <center>Nro</center>
                    </th>
                    <th>
                      <center>Nombre de la categoria</center>
                    </th>
                    <th>
                      <center>Accion</center>
                    </th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>
        </div>

        <!-- New Column for Invoice Details -->
        <div class="col-md-5">
              <div class="card card-outline card-secondary">
                <div class="card-header">
                  <h3 class="card-title mb-0">Detalles de Factura</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="invoice-number">Número de Factura:</label>
                    <input type="text" id="invoice-number" class="form-control" readonly value="000001">
                  </div>
                  <div class="form-group">
                    <label for="date">Fecha:</label>
                    <input type="text" id="date" class="form-control" readonly value="<?php echo date('d-m-Y'); ?>">
                  </div>
                  <div class="form-group">
                    <label for="subtotal">Subtotal:</label>
                    <input type="text" id="subtotal" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                    <label for="iva">IVA (18%):</label>
                    <input type="text" id="iva" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                    <label for="total">Total:</label>
                    <input type="text" id="total" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                    <label for="payment-method">Método de Pago:</label>
                    <select id="payment-method" class="form-control">
                      <option value="cash">Efectivo</option>
                      <option value="card">Tarjeta de Crédito/Débito</option>
                      <option value="bank">Transferencia Bancaria</option>
                    </select>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="button" class="btn btn-success">Imprimir Factura</button>
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




</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('views/layout/footer.php'); ?>
<script src="public/js/producto.js"></script>