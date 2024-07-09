<?php
include('app/config.php');
include($MODELS . 'tipo_pago.php');
$tipo = new Tipo();
$data_tipos = $tipo->Listar();
session_start();

if(isset($_POST['accion'])){
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
            $identificacion = $_POST['identificacion'];
            $nombre = $_POST['nombre'];
            $datos = $_POST['datos'];
        
            $result = $tipo->Crear($nombre, $identificacion, $datos);
            
            $response = array();
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Tipo de pago registrado exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar el tipo de pago.";
            }
            
            echo json_encode($response);
            return 0;
        break;

        //Para consultar el registro a modificar
        case 'consultar':
            $data = $tipo->Buscar($_POST['id_tipo_pago']);
            foreach ($data as $valor) {
                echo json_encode([
                    'id_tipo_pago' => $valor['id_tipo_pago'],
                    'nombre' => $valor['nombre'],
                    'identificacion' => $valor['identificacion'],
                    'datos' => $valor['datos']
                ]);
            }
            return 0;
        break;

        //Para eliminar un registro
        case 'eliminar':
            $result = $tipo->Eliminar($_POST['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Tipo de pago Eliminado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar el tipo de pago.";
            }
            echo json_encode($respuesta);
            return 0;
        break;

        //Para modificar los datos
        case 'modificar':
            $identificacion = $_POST['identificacion'];
            $nombre = $_POST['nombre'];
            $datos = $_POST['datos'];
            $id_tipo_pago = $_POST['id_tipo_pago'];

        
            $result = $tipo->Modificar($id_tipo_pago, $nombre, $identificacion, $datos);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Tipo de pago Modificado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar el tipo de pago.";
            }
            echo json_encode($respuesta);
            return 0;
        break;            

    }
}
include($VIEW.'tipo_pago.php'); 
