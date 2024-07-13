<?php
include('app/config.php');
session_start();

include($MODELS . 'caja.php');
$caja = new Caja();

//Para listar cajas 
$data_cajas = $caja->Listar();
if(isset($_POST['accion'])){
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
            $cantidad = $_POST['cantidad'];
            $descripcion = $_POST['descripcion'];
        
            $result = $caja->Crear($cantidad, $descripcion);
            
            $response = array();
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Caja registrada exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar la caja.";
            }
            
            echo json_encode($response);
            return 0;
        break;

        //Para consultar el registro a modificar
        case 'consultar':
            $data = $caja->Buscar($_POST['id_caja']);
            foreach ($data as $valor) {
                echo json_encode([
                    'id_caja' => $valor['id_caja'],
                    'cantidad' => $valor['cantidad'],
                    'descripcion' => $valor['descripcion']
                ]);
            }
            return 0;
        break;

        //Para eliminar un registro
        case 'eliminar':
            $result = $caja->Eliminar($_POST['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Caja Eliminada exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar la caja.";
            }
            echo json_encode($respuesta);
            return 0;
        break;

        //Para modificar los datos
        case 'modificar':
            $id = $_POST['id_caja'];
            $cantidad = $_POST['cantidad'];
            $descripcion = $_POST['descripcion'];
        
            $result = $caja->Modificar($id, $cantidad, $descripcion);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Caja Modificada exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar la caja.";
            }
            echo json_encode($respuesta);
            return 0;
        break;            

    }
}


include($VIEW.'caja.php'); 
?>