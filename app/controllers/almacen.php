<?php
include('app/config.php');

session_start();

include($MODELS . 'almacen.php');
$almacen = new Almacen();

//Para listar categorias 
$data_almacen = $almacen->Listar();
if(isset($_POST['accion'])){
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
            $nombre = $_POST['nombre_categoria'];
            $fecha = date("Y-m-d H:i:s"); 
        
            $result = $categoria->Crear($nombre, $fecha, $fecha);
            
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




include($VIEW.'almacen.php'); 