<?php include('views/layout/menu.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de roles</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">Roles registrados</h3>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Rol</th>
                                        <th>Nombre de Rol</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rol_datos)) {
                                        foreach ($rol_datos as $data_user) { ?>
                                            <tr>
                                                <td><?php echo $data_user['cod_tipo_usuario']; ?></td>
                                                <td><?php echo $data_user['rol']; ?></td>
                                            
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="3">No hay roles registrados</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            
            </div>
        </div>
    </div>
</div>
<?php include('views/layout/footer.php'); ?>
