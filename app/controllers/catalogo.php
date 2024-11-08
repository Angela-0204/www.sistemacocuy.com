<?php
include('app/config.php');
include($MODELS . 'producto.php');
include($MODELS . 'cliente.php');
include($MODELS . 'pedido.php');
$cliente = new Cliente();
$producto = new Producto();
$pedido = new Pedido();
$data_clientes = $cliente->Listar();
session_start();

$data_inventarios = $producto->ListarInventarios();
if (isset($_POST['accion'])) {
    date_default_timezone_set('UTC');

    switch ($_POST['accion']) {
        case 'registrar':
            $cod_cliente = $_POST['cod_cliente'];
            $id_usuario = $_SESSION['id_user'];
            $fecha_pedido = $_POST['fecha_pedido']; // Captura la fecha del pedido
            $productos = json_decode($_POST['productos'], true); // Decodificar los productos JSON
            
            // Aquí deberías tener una función que maneje el registro del pedido
            $result = $pedido->Crear($cod_cliente, $id_usuario, $fecha_pedido, $productos); // Asegúrate de que esta función esté implementada

            $response = array();
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Pedido guardado exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al guardar el pedido.";
            }
            echo json_encode($response);
            return 0;
        break;
        
    }
}
if (isset($_POST['cod_inventario'])) {
    $cod_inventario = $_POST['cod_inventario'];
    $presentaciones = $producto->ListarPresentacionesPorInventario($cod_inventario);
    
    // Enviar los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($presentaciones);
    exit;
}



include($VIEW.'catalogo.php'); 
?>


