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
                            <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-rol">Añadir Rol</button>
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
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rol_datos)) {
                                        foreach ($rol_datos as $data_user) { ?>
                                            <tr>
                                                <td><?php echo $data_user['id_rol']; ?></td>
                                                <td><?php echo $data_user['nombre_rol']; ?></td>
                                                <td>
                                                    <a href="?pagina=roles&accion=consultar&id=<?=$data_user['id_rol']; ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="?pagina=roles&accion=eliminar&id=<?=$data_user['id_rol']; ?>" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
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

            <!-- Modal Añadir Rol -->
            <div class="modal fade" id="modal-add-rol" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Añadir Nuevo Rol</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="post">
                            <input type="text" name="accion" value="registrar">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nombre_rol">Nombre del Rol</label>
                                    <input type="text" name="nombre_rol" class="form-control" placeholder="Escriba aquí el nombre del nuevo rol" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button id="registrar" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
if (isset($script)) {
    echo $script;
}?>
<?php include('views/layout/footer.php'); ?>