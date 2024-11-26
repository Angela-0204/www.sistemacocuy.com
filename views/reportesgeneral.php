<?php include('views/layout/menu.php'); ?>
<style>
  .small-box-footer {
    background-color: rgba(0, 0, 0, .1);
    color: rgba(255, 255, 255, .8);
    display: block;
    padding: 3px 0;
    position: relative;
    text-align: center;
    text-decoration: none;
    z-index: 10;
}
</style>
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
            <div class="row">
              <div class="col-12">
                <select name="" class="form-control" id="tipo-reporte">
                  <option value="1" selected>Reporte general</option>
                  <option value="2">Por rango de fecha</option>
                </select>
              </div>
              <div class="col-6 fechas" style="display: none;">
                <label for="">Fecha desde</label>
                <input type="date" class="form-control" name="fecha_desde_inventario">
              </div>
              <div class="col-6 fechas" style="display: none;">
                <label for="">Fecha hasta</label>
                <input type="date" class="form-control" name="fecha_hasta_inventario">
              </div>
            </div>
            
          </div>
          <div class="general">
            <a href="#" onclick="generarInventarioGeneral('inventario_general');">
              <div class="icon">
                <i class="nav-icon fas fa-sharp-duotone  fa-file-pdf"></i>
              </div>
            </a>
            <a href="#" onclick="generarInventarioGeneral('inventario_general');" class="small-box-footer" style="color:black" >
              Generar Reporte General en PDF <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
          <div class="rango" style="display: none;">
            <a href="#" onclick="generarInventarioFecha('inventario_rangos');">
              <div class="icon">
                <i class="nav-icon fas fa-sharp-duotone  fa-file-pdf"></i>
              </div>
            </a>
            <a href="#" onclick="generarInventarioFecha('inventario_rangos');" class="small-box-footer" style="color:black" >
              Generar Reporte por fechas en PDF <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
          
        </div>
      </div>

      <!-- Segundo cuadro -->
      <div class="col-md-4">
      <div class="small-box" style="border: 2px solid #000000; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px;">
          <div class="inner">
            <h3>Pedido</h3>
            <p>Reporte de Pedidos</p>
          <div class="row">
              <div class="col-12">
                <select name="" class="form-control" id="tipo-reporte-pedido">
                  <option value="1" selected>Reporte general</option>
                  <option value="2">Por rango de fecha</option>
                </select>
              </div>
              <div class="col-6 fechas-pedido" style="display: none;">
                <label for="">Fecha desde</label>
                <input type="date" class="form-control" name="fecha_desde_pedido">
              </div>
              <div class="col-6 fechas-pedido" style="display: none;">
                <label for="">Fecha hasta</label>
                <input type="date" class="form-control" name="fecha_hasta_pedido">
              </div>
            </div>
          </div>
          <div class="general-pedido">
            <a href="#" onclick="generarPedidoGeneral('pedido_general');">
              <div class="icon">
                <i class="nav-icon fas fa-sharp-duotone  fa-file-pdf"></i>
              </div>
            </a>
            <a href="#" onclick="generarPedidoGeneral('pedido_general');" class="small-box-footer" style="color:black" >
              Generar Reporte General en PDF <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
          <div class="rango-pedido" style="display: none;">
            <a href="#" onclick="generarPedidoFecha('pedido_rangos');">
              <div class="icon">
                <i class="nav-icon fas fa-sharp-duotone  fa-file-pdf"></i>
              </div>
            </a>
            <a href="#" onclick="generarPedidoFecha('pedido_rangos');" class="small-box-footer" style="color:black" >
              Generar Reporte por fechas en PDF <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
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
          <a href="#" onclick="generar('reporte_clientes');">
            <div class="icon">
              <i class="nav-icon fas fa-sharp-duotone  fa-file-pdf"></i>
            </div>
          </a>
          <a href="#" onclick="generar('reporte_clientes');" class="small-box-footer" style="color:black">
            Generar Reporte en PDF <i class="fas fa-arrow-circle-right"></i>
          </a>
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
          <a onclick="generar('reporte_pagos');">
            <div class="icon">
              <i class="nav-icon fas fa-sharp-duotone  fa-file-excel"></i>
            </div>
          </a>
          <a href="#" onclick="generar('reporte_pagos');" class="small-box-footer" style="color:black">
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
