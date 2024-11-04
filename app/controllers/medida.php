<?php
include('app/config.php');
session_start();

include($MODELS . 'medida.php');
$ml = new Medida();

//Para listar categorias 
$data_medida = $ml->Listar();
if(isset($_POST['accion'])){
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
            $medida = $_POST['medida'];
            
        
            $result = $ml->Crear($medida);
            
            $response = array();
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Medida registrada exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar la medida.";
            }
            
            echo json_encode($response);
            return 0;
        break;

        //Para consultar el registro a modificar
        case 'consultar':
            $data = $ml->Buscar($_POST['cod_unidad']);
            foreach ($data as $valor) {
                echo json_encode([
                    'cod_unidad' => $valor['cod_unidad'],
                    'medida' => $valor['medida']
                ]);
            }
            return 0;
        break;

        //Para eliminar un registro
        case 'eliminar':
            $result = $ml->Eliminar($_POST['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Medida Eliminada exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar la Medida.";
            }
            echo json_encode($respuesta);
            return 0;
        break;

        //Para modificar los datos
        case 'modificar':
            $id = $_POST['cod_unidad'];
            $medida = $_POST['medida'];

            $result = $ml->Modificar($id, $medida);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Medida Modificada exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar la Medida.";
            }
            echo json_encode($respuesta);
            return 0;
        break;            

    }
}


include($VIEW.'medida.php'); 
?>