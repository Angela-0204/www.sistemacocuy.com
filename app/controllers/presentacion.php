<?php
include('app/config.php');

session_start();

include($MODELS . 'presentacion.php');
$presentacion = new Presentacion();

//Para listar  
$data_presentacion = $presentacion->Listar();
if(isset($_POST['accion'])){
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
            $id_presentacion = $_POST['id_presentacion'];
            $litraje = $_POST['litraje']; 
        
            $result = $presentacion->Crear($id_presentacion, $litraje);
            
            $response = array();
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Categoria registrada exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar la categoria.";
            }
            
            echo json_encode($response);
            return 0;
        break;

    
        }
    }


















include($VIEW.'presentacion.php'); 