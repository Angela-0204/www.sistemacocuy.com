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

                <a href="?pagina=inventario">
                  <button type="submit" class="btn btn-primary ml-3"> Consultar Inventario</button>
                </a>
              </div>
              <div class="ml-auto">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

<<<<<<< HEAD
                                        <th>Cerrar Sesion</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <a href="?pagina=login" id="salir-vendedor" class="btn-2">Salir</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="header-content container">
            <div class="header-img">
                <img src="<?php echo $URL; ?>/public/images/fondoinfo-removebg-preview.png" alt="">
            </div>
            <div class="header-txt">
                <h1>Realiza tus pedidos con nosotros</h1>
                <p>Disfruta de nuestros licores a base de cocuy</p>
               
=======
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
>>>>>>> e6429ed557ca7a8530f34840ae187a6f6d36e284
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
        <button type="button" class="btn btn-primary" id="addProductButton">Agregar</button>
      </div>
    </div>
  </div>
</div>

<?php include('views/layout/footer.php'); ?>

<script src="public/js/catalogo.js"></script>
