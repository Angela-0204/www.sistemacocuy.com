<?php include('views/layout/menu.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de Clientes</h1>
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
                <h3 class="card-title mb-0">Clientes registrados</h3>

                <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modal-add-usuario">Añadir Nuevo Cliente</button>


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
                <th>Codigo</th>
                  <th>Cedula</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Direccion</th>
                  <th>Estatus</th>
                </tr>
                <tbody>
                  <?php
                  foreach ($data_cliente as $data_clientes) { ?>
                    <tr>
                    <td><?php echo $data_clientes['cod_cliente'] ?></td>
                      <td><?php echo $data_clientes['cedula_rif'] ?></td>
                      <td><?php echo $data_clientes['nombre_cliente'] ?></td>
                      <td><?php echo $data_clientes['apellido'] ?></td>
                      <td><?php echo $data_clientes['correo'] ?></td> 
                      <td><?php echo $data_clientes['telefono'] ?></td>
                      <td><?php echo $data_clientes['direccion'] ?></td>
                      <td><?php echo $data_clientes['estatus'] ?></td>
                  
                      <td>
                        <button onclick="editar(<?php echo $data_clientes['cedula_rif']; ?>)" class="btn btn-warning btn-sm">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="eliminar(<?php echo $data_clientes['cod_cliente']; ?>)" class="btn btn-danger btn-sm">
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
                  <label for="cedula_rif">Cedula del cliente <span class="required">*</span> </label>
                  <input type="text" name="cedula_rif" id="cedula_rif" class="form-control" placeholder="Escriba aquí la cedula o el RIF del cliente">
                  <span id="cedula_rifError" class="text-danger"></span>
               
                </div>

                <div class="form-group">
                  <label for="nombre_cliente">Nombre del cliente <span class="required">*</span></label>
                  <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" placeholder="Escriba aquí el nombre del nuevo cliente">
                  <span id="nombre_clienteError" class="text-danger"></span>
                </div>
                <div class="form-group">
                  <label for="apellido">Apellido del cliente<span class="required">*</span></label>
                  <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Escriba aquí el apellido del nuevo cliente">
                  <span id="apellidoError" class="text-danger"></span>
                </div>

                <div class="form-group">
                  <label for="">Correo <span class="required">*</span></label>
                  <input type="email" name="correo" id="correo" class="form-control" placeholder="Escriba aquí el Correo del Nuevo cliente">
                  <span id="correoError" class="text-danger"></span>
                </div>
                <div class="form-group">
                  <label for="direccion">Direccion <span class="required">*</span> </label>
                  <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Escriba aquí la direccion del nuevo cliente">
                  <span id="direccionError" class="text-danger"></span>
                </div>

                <div class="form-group">
  <label for="telefono">Telefono <span class="required">*</span></label>
  <div class="d-flex">
    <select class="form-control" id="operadora" name="operadora" style="width: auto; margin-right: 10px;">
      <option value="0414">0414</option>
      <option value="0424">0424</option>
      <option value="0412">0412</option>
      <option value="0426">0426</option>
      <option value="0416">0416</option>
      <option value="0251">0251</option>
      <option value="0212">0212</option>
    </select>
    
    <input type="text" name="telefono" id="telefono" maxlength="7"  class="form-control" placeholder="Escriba el número telefónico">
    
  </div>
  <span id="telefonoError" class="text-danger"></span>
          </div>
            
        <div class="col-md-12 form-group">
       <label for="estatus">Estatus *</label>
         <select class="form-control" name="estatus">
        <option value="activo">Activo</option>
        <option value="inactivo">Inactivo</option>
        </select>
                        </div>

        
            
                <hr>
                <div class="form-group">
                  <a href="" class="btn btn-secondary">Cancelar</a>
                  <button id="registrar" class="btn btn-primary">Guardar</button>
                </div>
              </div>


            </form>
          </div>
        </div>
      </div>

      
      <div class="modal fade" id="modal-edit-users" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
           
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="post">
    <div class="modal-body">
        <input type="hidden" id="cedula_rif_editar" name="cedula_rif_editar">

        <div class="form-group">
            <label for="nombre_cliente_edit">Nombre <span class="required">*</span></label>
            <input type="text" name="nombre_cliente_edit" id="nombre_cliente_edit" class="form-control" placeholder="Escriba el nombre del cliente">
            <span id="nombre_cliente_editError" class="text-danger"></span>
          </div>

        <div class="form-group">
            <label for="apellido_edit">Apellido <span class="required">*</span></label>
            <input type="text" name="apellido_edit" id="apellido_edit" class="form-control" placeholder="Escriba el apellido del cliente">
            <span id="apellido_editError" class="text-danger"></span>
          </div>

        <div class="form-group">
            <label for="email_edit">Correo <span class="required">*</span></label>
            <input type="email" name="email_edit" id="email_edit" class="form-control" placeholder="Escriba el correo del cliente">
            <span id="email_editError" class="text-danger"></span>
          </div>

        <div class="form-group">
            <label for="direccion_edit">Dirección <span class="required">*</span></label>
            <input type="text" name="direccion_edit" id="direccion_edit" class="form-control" placeholder="Escriba la dirección del cliente">
            <span id="direccion_editError" class="text-danger"></span>
          </div>

          <div class="form-group">
  <label for="telefono_edit">Telefono <span class="required">*</span></label>
  <div class="d-flex">
    <select class="form-control" id="operadora_edit" name="operadora" style="width: auto; margin-right: 10px;">
      <option value="0414">0414</option>
      <option value="0424">0424</option>
      <option value="0412">0412</option>
      <option value="0426">0426</option>
      <option value="0416">0416</option>
      <option value="0251">0251</option>
      <option value="0212">0212</option>
    </select>
    
    <input type="text" name="telefono_edit" id="telefono_edit" maxlength="7"  class="form-control" placeholder="Escriba el número telefónico">
    
  </div>
  <span id="telefono_editError" class="text-danger"></span>
          </div>
            
        <div class="col-md-12 form-group">
       <label for="estatus">Estatus *</label>
         <select class="form-control" name="estatus_edit">
        <option value="activo">Activo</option>
        <option value="inactivo">Inactivo</option>
        </select>
                        </div>

        <hr>
        <div class="form-group">
            <a href="" class="btn btn-secondary">Cancelar</a>
            <button id="modificar" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>



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
<script src="public/js/cliente.js"></script>