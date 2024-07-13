<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Lista de Bancos</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <h2>Selecciona un método de pago</h2>
          <div class="list-group">

            <button class="list-group-item list-group-item-action" onclick="showModal('bank')">Banco</button>
            <button class="list-group-item list-group-item-action" onclick="showModal('mobile')">Pago Móvil</button>
            <button class="list-group-item list-group-item-action" onclick="showModal('credit')">Tarjeta de Crédito</button>
            <button class="list-group-item list-group-item-action" onclick="showModal('qr')">Pago Móvil QR</button>
          
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="paymentModalLabel">Detalles del Pago</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="personType">Tipo de Persona</label>
                  <input type="text" class="form-control" id="personType" placeholder="Tipo de Persona">
                </div>
                <div class="form-group">
                  <label for="document">Documento</label>
                  <input type="text" class="form-control" id="document" placeholder="Documento">
                </div>
                <div class="form-group">
                  <label for="bank">Banco</label>
                  <select class="form-control" id="bank">
                    <option>Selecciona un banco</option>
                    <option>Banco 1</option>
                    <option>Banco 2</option>
                    <option>Banco 3</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="phone">Teléfono</label>
                  <input type="text" class="form-control" id="phone" placeholder="Teléfono">
                </div>
                <div class="form-group">
                  <label for="amount">Monto</label>
                  <input type="text" class="form-control" id="amount" placeholder="Monto">
                </div>
                <div class="form-group">
                  <label for="concept">Concepto</label>
                  <input type="text" class="form-control" id="concept" placeholder="Concepto">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('views/layout/footer.php'); ?>

<script src="public/js/banco.js"></script>
