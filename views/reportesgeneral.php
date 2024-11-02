<?php include('views/layout/menu.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Bienvenido Usuario</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="container-fluid">
    <div class="row">
      <!-- Primer cuadro -->
      <div class="col-md-4">
      <div class="small-box" style="border: 2px solid #000000; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px;">
          <div class="inner">
            <h3>Inventario</h3>
            <p>Reporte de Inventario</p>
          </div>
          <a href="?pagina=reporteinventario">
            <div class="icon">
              <i class="nav-icon fas fa-file-excel"></i>
            </div>
          </a>
          <a href="?pagina=reporteinventario" class="small-box-footer" style="color:black" >
            Generar Reporte en Excel <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Segundo cuadro -->
      <div class="col-md-4">
      <div class="small-box" style="border: 2px solid #000000; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px;">
          <div class="inner">
            <h3>Pedido</h3>
            <p>Reporte de Pedidos</p>
          </div>
          <a href="#" onclick="generar('reporte_pedido');">
            <div class="icon">
              <i class="nav-icon fas fa-sharp-duotone  fa-file-pdf"></i>
            </div>
          </a>
          <a href="#" onclick="generar('reporte_pedido');" class="small-box-footer" style="color:black">
            Generar Reporte en PDF <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <!-- Primer cuadro -->
      <div class="col-md-4">
      <div class="small-box" style="border: 2px solid #000000; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px;">
          <div class="inner">
            <h3>Clientes</h3>
            <p>Reporte de Clientes</p>
          </div>
          <a href="?pagina=reporteinventario">
            <div class="icon">
              <i class="nav-icon fas fa-sharp-duotone  fa-file-pdf"></i>
            </div>
          </a>
          <a href="?pagina=reporteinventario" class="small-box-footer" style="color:black">
            Generar Reporte en PDF <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Segundo cuadro -->
      <div class="col-md-4" >
      <div class="small-box" style="border: 2px solid #000000; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px;">
          <div class="inner">
            <h3>Pagos</h3>
            <p>Reporte de pagos</p>
          </div>
          <a href="?pagina=reporteinventario">
            <div class="icon">
              <i class="nav-icon fas fa-sharp-duotone  fa-file-excel"></i>
            </div>
          </a>
          <a href="?pagina=reporteinventario" class="small-box-footer" style="color:black">
            Generar Reporte en Excel <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
  <!-- /.container-fluid -->
</div>

<!-- /.content-wrapper -->





        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  
  <!-- /.content-wrapper -->
  <?php include('views/layout/footer.php'); ?>
<script src="public/js/reportes.js"></script>
