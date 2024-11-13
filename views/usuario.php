<?php include('views/layout/menu.php'); ?>
<style>
.password-container {
    position: relative;
}

.password-container .form-control {
    padding-right: 30px; /* Espacio para el ícono a la derecha */
}

.password-container i {
    position: absolute;
    right: 10px;
    top: 65%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #888; /* Color del ícono, ajustable */
}

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de usuario</h1>
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
                <h3 class="card-title mb-0">Usuarios registrados</h3>

                <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-usuario">Añadir Usuario</button>


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
                  <th>Nro</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Rol</th>
                 
                 
                </tr>
                <tbody>
                  <?php
                  foreach ($data_users as $data_user) { ?>
                    <tr>
                      <td><?php echo $data_user['id_users'] ?></td>
                      <td><?php echo $data_user['names'] ?></td>
                      <td><?php echo $data_user['email'] ?></td>
                      <td><?php echo $data_user['rol'] ?></td>
                  
                      <td>
                        <button onclick="editar(<?php echo $data_user['id_users']; ?>)" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="eliminar(<?php echo $data_user['id_users']; ?>)" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
   
      <div class="modal fade" id="modal-add-usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              
            </div>
            <form action="" method="post">
              <div class="modal-body">
                <div class="form-group">
                  <label for="names">Nombre de Usuario <span class="required">*</span></label>
                  <input type="text" name="names" class="form-control" id="names" maxlength="25" placeholder="Escriba aquí el nombre del Nuevo Usuario">
                  <span id="namesError" class="text-danger"></span>
                </div>
                

                <div class="form-group">
                  <label for="email">Email  <span class="required">*</span></label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Escriba aquí el Email del Nuevo Usuario">
                  <span id="emailError" class="text-danger"></span>
                </div>

                      <div class="col align-self-center-md-4 form-group">
                        <label for="">Roles</label>
                        <select name="roles" id="roles" class="form-control">
                          <?php foreach ($data_rol as $rol_dato) { ?>
                            <option value="<?= $rol_dato['cod_tipo_usuario']; ?>"><?php echo $rol_dato['rol']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
            
<!-- Contraseña -->
<div class="form-group password-container">
  <label for="password_user">Contraseña <span class="required">*</span></label>
  <input name="password_user" id="password_user" class="form-control">
  <span id="password_userError" class="text-danger"></span>
  <i id="togglePassword1" class="fas fa-eye"></i> <!-- El ícono fuera del input -->
</div>

<div class="form-group password-container">
  <label for="password_repeat">Repetir Contraseña <span class="required">*</span></label>
  <input  name="password_repeat" id="password_repeat" class="form-control">
  <i id="togglePassword2" class="fas fa-eye"></i> <!-- El ícono fuera del input -->
</div>




   <hr>
                <div class="form-group">
                  <a href="" class="btn btn-secondary">Cancelar</a>
                  <button disabled id="registrar" class="btn btn-primary">Guardar</button>
                </div>
              </div>


            </form>
          </div>
        </div>
      </div>

      <!-- Modal Editar Rol -->
      <div class="modal fade" id="modal-edit-users" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modificar Usuario</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="post">
              <div class="modal-body">
                <input type="hidden" id="id" name="id">
                <div class="form-group">
                  <label for="">Nombre <span class="required">*</span></label>
                  <input type="text" name="names_edit" id="names_edit" class="form-control" placeholder="Escriba aquí el nombre del Nuevo Usuario">
                  <span id="names_editError" class="text-danger"></span>
                </div>
               

                <div class="form-group">
                  <label for="">Email <span class="required">*</span></label>
                  <input type="email_edit" name="email_edit" id="email_edit" class="form-control" placeholder="Escriba aquí el Email del Nuevo Usuario">
                  <span id="email_editError" class="text-danger"></span>
                </div>

                <div class="col align-self-center-md-4 form-group">
                        <label for="">Roles</label>
                        <select name="roles_edit" id="roles_edit" class="form-control">
                          <?php foreach ($data_rol as $rol_dato) { ?>
                            <option value="<?= $rol_dato['cod_tipo_usuario']; ?>"><?php echo $rol_dato['rol']; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group password-container">
                      <label for="password_user_edit">Contraseña <span class="required">*</span></label>
                      <input name="password_user_edit" id="password_user_edit" class="form-control">
                      <span id="password_user_editError" class="text-danger"></span>
                      <i id="togglePassword3" class="fas fa-eye"></i> <!-- El ícono fuera del input -->
                     </div>

                <hr>
                <div class="form-group">
                  <a href="" class="btn btn-secondary">Cancelar</a>
                  <button id="modificar" class="btn btn-primary">Guardar</button>
                </div>
              </div>


            </form>
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
<script src="public/js/usuario.js"></script>