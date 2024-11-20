<?php
include('app/config.php');
session_start();
// Verificar si la sesión está activa
if (!isset($_SESSION['id_user']) || $_SESSION['rol']!= 1) {
    // Si no está iniciada la sesión, redirigir al login
    header('Location: ?pagina=login');
    exit();  // Asegura que no se ejecute el código restante de la página
}
include($MODELS . 'marcas.php');
include($MODELS . 'medida.php');

$ml = new Medida();
$marcas = new Marcas();

//Para listar categorias 
$data_medida = $ml->Listar();
$data_marcas = $marcas->Listar();
if(isset($_POST['accion'])){
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
            $marca = $_POST['marca'];
            $medida =$_POST['medida'];

    
            $result = $marcas->Crear($marca,$medida);
            
            $response = array();
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Marca registrada exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar la marca.";
            }
            
            echo json_encode($response);
            return 0;
        break;

        //Para consultar el registro a modificar
        case 'consultar':
            $data = $marcas->Buscar($_POST['id_presentacion']);
            foreach ($data as $valor) {
                echo json_encode([
                    'id_presentacion' => $valor['id_presentacion'],
                    'marca' => $valor['marca'],
                    'medida' => $valor['cod_unidad']
                ]);
            }
            return 0;
        break;

        //Para eliminar un registro
        case 'eliminar':
            $result = $marcas->Eliminar($_POST['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Marca Eliminada exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar la Marca.";
            }
            echo json_encode($respuesta);
            return 0;
        break;

        //Para modificar los datos
        case 'modificar':
            $id = $_POST['id_presentacion'];
            $marca = $_POST['marca'];
            $cod_unidad = $_POST['medida'];           
        
            $result = $marcas->Modificar($id, $marca, $cod_unidad);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Marcas Modificada exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar la Marcas.";
            }
            echo json_encode($respuesta);
            return 0;
        break;            

    }
}


include($VIEW.'marcas.php'); 
?>