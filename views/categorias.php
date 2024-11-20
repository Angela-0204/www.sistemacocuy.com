<?php include('views/layout/menu.php'); 
include('app/controllers/listado_categorias.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Listado de categorias</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
      <div class="row">
          <div class="col-md-6">
            <div class="card card-outline card-primary">
              <div class="card-header ">
                  <h3 class="card-title ">Categorias registradas</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                  </div>
                
              </div>
              <div class="card-body" >
                <table id="examplel" class="table table-bordered table-atriped">
                <thead>
                    <tr>
                        <th><center>Nro</center></th>
                        <th><center>Nombre de la categoria</center></th>
                        <th><center>Accion</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador =0;
                    foreach ($categorias_datos as $categorias_dato) {
                        $id_categoria = $categorias_dato['id_categoria'];?> 
                   
                    <tr>
                        <td><center><?php echo $contador =$contador + 1; ?></center></td>
                        <td><?php echo $categorias_dato['nombre_categoria'];?></td>
                        <td>
                            <center>
                                <div class="btn-group">
                                    <a href="update.php?id=<?php echo $id_categoria;?>" type="button" class="btn btn-success">
                                        <li class="fa fa-pencil-alt"></li>Editar</a>
                                </div>
                            </center>
                        </td>
                    </tr>
                    <?php
                    }?>
                </tbody>
                <tfoot>
                    <tr>
                        <th><center>Nro</center></th>
                        <th><center>Nombre de la categoria</center></th>
                        <th><center>Acciones</center></th>
                    </tr>
                </tfoot>
                </table>
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