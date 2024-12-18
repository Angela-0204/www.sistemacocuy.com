<?php
include('app/config.php');
include($MODELS . 'tipo_pago.php');
$tipo = new Tipo();
$data_tipos = $tipo->Listar();
session_start();
// Verificar si la sesión está activa
if (!isset($_SESSION['id_user']) || $_SESSION['rol']!= 1) {
    // Si no está iniciada la sesión, redirigir al login
    header('Location: ?pagina=login');
    exit();  // Asegura que no se ejecute el código restante de la página
}
if(isset($_POST['accion'])){
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
          
            $nombre = $_POST['nombre'];
           
             
    // Verificar si el nombre ya existe
    if ($tipo->VerificarNombre($nombre)) {
        echo json_encode([
            'estatus' => 0,
            'mensaje' => "El tipo de pago ya existe, por favor ingrese otro nombre."
        ]);
        return 0;
    }



        
            $result = $tipo->Crear($nombre);
            
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
                    'nombre' => $valor['nombre']
                   
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

            $id_tipo_pago = $_POST['id_tipo_pago'];
            $nombre = $_POST['nombre'];
         
        
            $result = $tipo->Modificar($id_tipo_pago, $nombre);
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
            
  case 'verificarNombre':
    $nombre = $_POST['nombre'];
    $existe = $tipo->VerificarNombre($nombre);
    echo json_encode(['existe' => $existe]);
    return 0;
    }
    
  
}



include($VIEW.'tipo_pago.php'); 
