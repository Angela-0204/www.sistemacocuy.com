<?php
session_start();
// Verificar si la sesión está activa
if (!isset($_SESSION['id_user'])) {
    // Si no está iniciada la sesión, redirigir al login
    header('Location: ?pagina=login');
    exit();  // Asegura que no se ejecute el código restante de la página
}
include('app/config.php');
include($MODELS . 'reporte_pago.php');
include ($MODELS . 'tipo_pago.php');
$tipo = new Tipo();
$reporte = new Reporte_pago();
$data_tipos = $tipo->Listar();
$data_reportes = $reporte->Listar();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
           
           
            $id_detalle_pago = $_POST ['id_detalle_pago'];
            
             $monto = $_POST ['monto'];
            $referencia = $_POST ['referencia'];
            $nombre = $_POST ['nombre'];
             $fyh_pago = $_POST['fyh_pago'];
            
            
        
             $result = $reporte->Crear($monto, $id_detalle_pago, $referencia, $nombre, $fyh_pago);

            
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


include($VIEW.'reportar_pago.php'); 
?>