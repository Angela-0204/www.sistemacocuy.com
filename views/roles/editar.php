<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Rol</h1>
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
                                <h3 class="card-title mb-0">Modificar Rol</h3>
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
                                    <form action="" method="post">
                                        <input type="hidden" name="accion" value="modificar">
                                        <?php foreach ($data as $value) { ?>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <input type="hidden" name="id_rol" value="<?php echo $value['id_rol']; ?>">
                                                    <label for="nombre_editar">Nombre del Rol</label>
                                                    <input type="text" name="nombre_rol" value="<?php echo $value['nombre_rol']; ?>" class="form-control" placeholder="Escriba aquí el nombre del nuevo rol" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a href="" class="btn btn-secondary">Cancelar</a>
                                                <button id="modificar" class="btn btn-primary">Guardar</button>
                                            </div>
                                        <?php } ?>

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
<?php 
if (isset($script)) {
    echo $script;
}?>
<?php include('views/layout/footer.php'); ?>