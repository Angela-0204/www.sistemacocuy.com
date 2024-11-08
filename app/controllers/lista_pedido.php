<?php
include('app/config.php');
include($MODELS . 'pedido.php');
$pedido = new Pedido();
session_start();
$data_pedido = $pedido->Listar();

if(isset($_POST['accion'])){
    switch($_POST['accion']){  
        //Para consultar el registro a modificar
        case 'consultar':
            // Obtener los datos del pedido
            $data = $pedido->ConsultarPedido($_POST['id_pedido']);
            
            // Verificar si hay un error en los datos recibidos
            if (isset($data['error'])) {
                echo json_encode(['error' => $data['error']]);
            } else {
                // Devolver la respuesta con los datos del pedido
                echo json_encode($data);
            }
            return 0;
        break;
            
        case 'eliminar':
            $cod_inventario = $_POST['id']; // Verifica que este ID sea correcto.
            $result = $producto->Eliminar($cod_inventario);
            
            // Prepara la respuesta
            if ($result) {
                $respuesta = [
                    'estatus' => 1,
                    'mensaje' => "Producto eliminado exitosamente."
                ];
            } else {
                $respuesta = [
                    'estatus' => 0,
                    'mensaje' => "Error al eliminar el producto o producto no encontrado."
                ];
            }
            
            // Establece el tipo de contenido de la respuesta
            header('Content-Type: application/json');
            echo json_encode($respuesta);
            exit;
            break;
    }
    
}

if (isset($_GET['reporte'])) {
    $id = $_GET['reporte'];
        // Generar el PDF y devolver la URL para abrir el archivo
        $pdfFilePath = 'app/reportes/pedido.php';

        // Verifica si el archivo existe
        if (file_exists($pdfFilePath)) {
            $archivo = 'app/reportes/pedido.php?id_pedido='.$id;

            echo json_encode([
                "estatus" => 1,
                "url" => $archivo
            ]);
        } else {
            echo json_encode([
                "estatus" => 0,
                "mensaje" => "Error al generar el PDF."
            ]);
        }
        
    exit;
}

include($VIEW.'lista_pedido.php'); 


