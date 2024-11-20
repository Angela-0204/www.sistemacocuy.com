<?php
include('app/config.php');
require_once('app/models/rol.php');
session_start();

$rol = new Rol();
$rol_datos = $rol->Listar();

if (!isset($_SESSION['id_user']) || $_SESSION['rol']!= 1) {
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
            $nombre = $_POST['nombre_rol'];
            $fecha = date("Y-m-d H:i:s"); 
        
            $result = $rol->Crear($nombre, $fecha, $fecha);
            
            $response = array();
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Rol registrado exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar el rol.";
            }
            
            echo json_encode($response);
            return 0;
        break;

        //Para consultar el registro a modificar
        case 'consultar':
            $data = $rol->Buscar($_POST['id_rol']);
            foreach ($data as $valor) {
                echo json_encode([
                    'id_rol' => $valor['id_rol'],
                    'nombre_rol' => $valor['nombre_rol']
                ]);
            }
            return 0;
        break;

        //Para eliminar un registro
        case 'eliminar':
            $result = $rol->Eliminar($_POST['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Rol Eliminado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar la rol.";
            }
            echo json_encode($respuesta);
            return 0;
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
            echo json_encode($respuesta);
            return 0;
        break;            

    }
}
include($VIEW.'roles.php'); 
