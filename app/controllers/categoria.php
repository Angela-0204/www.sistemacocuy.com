<?php
include('app/config.php');
session_start();

include($MODELS . 'categoria.php');
$categoria = new Categoria();

//Para listar categorias 
$data_categorias = $categoria->Listar();
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

        //Para consultar el registro a modificar
        case 'consultar':
            $data = $categoria->Buscar($_POST['id_categoria']);
            foreach ($data as $valor) {
                echo json_encode([
                    'id_categoria' => $valor['id_categoria'],
                    'nombre_categoria' => $valor['nombre_categoria']
                ]);
            }
            return 0;
        break;

        //Para eliminar un registro
        case 'eliminar':
            $result = $categoria->Eliminar($_POST['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Categoria Eliminada exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar la categoria.";
            }
            echo json_encode($respuesta);
            return 0;
        break;

        //Para modificar los datos
        case 'modificar':
            $id = $_POST['id_categoria'];
            $nombre = $_POST['nombre_categoria'];
            $fecha = date("Y-m-d H:i:s"); 
        
            $result = $categoria->Modificar($id, $nombre, $fecha);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Categoria Modificada exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar la categoria.";
            }
            echo json_encode($respuesta);
            return 0;
        break;            

    }
}


include($VIEW.'categoria.php'); 
?>