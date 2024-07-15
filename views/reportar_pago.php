<?php include('views/layout/menu_usuario.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Reportar Pago</h1>
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
                  <h3 class="card-title mb-0">Registrar Pago de Pedido</h3>
                  
                </div>
                <div class="ml-auto">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>

              <div class="card-body">
              <div class="row">
                  <div class="col-md-12">
                    <form action="../app/controllers/usuarios/create.php" method="post">
                      <div class="form-group">
                        <label for="">Seleccione tipo de Pago</label>
                        <select class="form-control" > </select>
                      </div>

                      <div class="form-group">
                        <label for="">Seleccione El Banco </label>
                        <select class="form-control" > </select>
                        
                      </div>

                      <div class="form-group">
                        <label for="">Numero de Referencia</label>
                        <input type="text" name="referencia" class="form-control" placeholder="Escriba aquí el numero dereferencia del deposito">
                      </div>
                     
                     
                      <div class="form-group">
                        <label for="">Monto depositado en Bolivares</label>
                        <input type="text" name="monto" class="form-control" placeholder="Escriba aquí la cantidad depositada en bolivares">
                      </div>
                    
                      <div class="form-group">
                        <label for="">Fecha de realizacion del pago</label>
                        <input type="date" name="fecha" class="form-control" placeholder="Escriba aquí la fecha de realizacion del pago(dd/mm/aa/">
                      </div>
                      <div class=" form-group mb-3">
  
                      <label for="" >Agregar imagen del comprobante de pago</label>
                      <input class="form-control " id="formFileSm" type="file">
                    </div>
                      <div class="form-group">
                        <a href="" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                      </div>
                      <hr>
                    </form>
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