<?php
include('app/config.php');
session_start();

include($MODELS . 'banco.php');
include($MODELS . 'tipo_pago.php');
$banco = new Banco();
$data_banco = $banco->Listar();
$tipo = new Tipo();
$data_tipos = $tipo->Listar();

//Para listar categorias 

if(isset($_POST['accion'])){
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
            $nombre_banco = $_POST['nombre_banco'];
            $datos_banco = $_POST['datos_banco'];
            $nombre = $_POST['nombre'];
           
        
            $result = $banco->Crear($nombre_banco, $datos_banco, $nombre);
            
            $response = array();
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Banco registrada exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar la banco.";
            }
            
            echo json_encode($response);
            return 0;
        break;

        //Para consultar el registro a modificar
        case 'consultar':
            $data = $banco->Buscar($_POST['id_banco']);
            foreach ($data as $valor) {
                echo json_encode([
                    'id_banco' => $valor['id_banco'],
                    'nombre_banco' => $valor['nombre_banco'],
                    'datos_banco' => $valor['datos_banco'],
                    'id_tipo_pago' => $valor['id_tipo_pago']
                ]);
            }
            return 0;
        break;

        //Para eliminar un registro
        case 'eliminar':
            $result = $banco->Eliminar($_POST['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Banco Eliminado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar el Banco.";
            }
            echo json_encode($respuesta);
            return 0;
        break;

        //Para modificar los datos
        case 'modificar':
            $id = $_POST['id_banco'];
            $nombre_banco = $_POST['nombre_banco'];
            $datos_banco = $_POST['datos_banco'];
            $nombre = $_POST['nombre'];
            
          
        
            $result = $banco->Modificar($id, $nombre_banco, $datos_banco, $nombre);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Banco Modificada exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar el banco.";
            }
            echo json_encode($respuesta);
            return 0;
        break;            

    }
}


include($VIEW.'banco.php'); 
?>