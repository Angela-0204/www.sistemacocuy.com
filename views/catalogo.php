<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Hacer Pedido</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8">
          <div class="card card-outline card-primary">
            <div class="card-header d-flex align-items-center">
              <div class="d-flex align-items-center">
                <h3 class="card-title mb-0">Realizar Pedido</h3>
              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="card-body">
              <table class="table table-bordered table-hover">
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Sub-Total</th>
                </tr>
                <tbody id="order-items">
                  <!-- Order items will be dynamically added here -->
                </tbody>
              </table>
              <button type="button" class="btn btn-success mt-3" data-toggle="modal" data-target="#productModal">
                Agregar Producto
              </button>
               <button type="button" class="btn btn-success mt-3" >
               <a href="?pagina=hacer_compra"  style="color:white"> Comprar</a>
              </button>
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

<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Seleccionar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="productForm">
          <div class="form-group">
            <label for="productSelect">Producto</label>
            <select class="form-control" id="productSelect">
              <option value="Cocuy" data-price="4.50">Cocuy - $4.50</option>
              <option value="Macondo" data-price="5.50">Macondo - $5.50</option>
              <option value="Anis" data-price="8.30">Anis - $8.30</option>
            </select>
          </div>
          <div class="form-group">
            <label for="quantity">Cantidad</label>
            <input type="number" class="form-control" id="quantity" value="1" min="1">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="addProductButton">Agendar Pedido</button>
      </div>
    </div>
  </div>
</div>

<?php include('views/layout/footer.php'); ?>

<script src="public/js/catalogo.js"></script>
