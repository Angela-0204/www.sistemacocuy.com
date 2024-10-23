<?php
include('app/config.php');
require_once('app/models/rol.php');
session_start();

$rol = new Rol();
$rol_datos = $rol->Listar();

if (isset($_POST['accion'])) {
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch ($_POST['accion']) {
            //Para registrar
        case 'registrar':
            $nombre = $_POST['nombre_rol'];
            $fecha = date("Y-m-d H:i:s");

            $result = $rol->Crear($nombre, $fecha, $fecha);

            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Rol registrado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al registrar el rol.";
            }

            $script = "<script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Rol',
                    text: '".$respuesta['mensaje'] ."'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '?pagina=roles';
                    }
                });
            });
          </script>";
            break;

        //Para modificar los datos
        case 'modificar':
            $id = $_POST['id_rol'];
            $nombre = $_POST['nombre_rol'];
            $fecha = date("Y-m-d H:i:s");

            $result = $rol->Modificar($id, $nombre, $fecha);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Rol Modificado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar la rol.";
            }
            $script = "<script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Rol',
                    text: '".$respuesta['mensaje'] ."'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '?pagina=roles';
                    }
                });
            });
            </script>";
            break;
    }
}
if (isset($_GET['accion'])) {
    switch ($_GET['accion']) {
        case 'eliminar': {
            $result = $rol->Eliminar($_GET['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Rol Eliminado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar la rol.";
            }
            $script = "<script type='text/javascript'>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rol',
                        text: '" . $respuesta['mensaje'] . "'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '?pagina=roles';
                        }
                    });
                });
            </script>";
            break;
        }
        case 'consultar':
            $data = $rol->Buscar($_GET['id']);
            require_once($VIEW . 'roles/editar.php');
            break;
    }
}
include($VIEW . 'roles/index.php');
