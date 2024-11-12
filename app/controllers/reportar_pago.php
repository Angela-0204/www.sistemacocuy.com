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
include($MODELS . 'banco.php');
include($MODELS . 'pedido.php');
$pedido = new Pedido();
$data_pedidos = $pedido->ListarActivos();
$tipo = new Tipo();
$reporte = new Reporte_pago();
$banco = new Banco();
$data_banco = $banco->Listar();
$data_tipos = $tipo->Listar();
$data_reportes = $reporte->Listar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch($_POST['accion']){
        //Para registrar
        case 'registrar':                   
             $monto = $_POST ['monto'];
             $referencia = $_POST ['referencia'];
             $fyh_pago = $_POST['fyh_pago'];
             $id_banco = $_POST ['id_banco'];
             $id_pedido = $_POST ['id_pedido'];
            
        
             $result = $reporte->Crear($fyh_pago, $monto,  $referencia, $id_banco, $id_pedido);


            
            $response = array();
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Reporte registrado exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar el reporte.";
            }
            
            echo json_encode($response);
            return 0;
        break;

        //Para eliminar un registro
        case 'eliminar':
            $result = $reporte->Eliminar($_POST['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Pago Eliminado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar el Pago.";
            }
            echo json_encode($respuesta);
            return 0;
        break;
        case 'listar_bancos':
            $data = $banco->BuscarPorTipoPago($_POST['id_tipo_pago']);
            echo json_encode($data); // Devuelve los datos en formato JSON
            return 0;
        break;
        case 'mostrar_monto':
            $data = $pedido->ObtenerMonto($_POST['id_pedido']);
            echo json_encode($data); // Devuelve los datos en formato JSON
            return 0;
        break;

        
        

    }
}

include($VIEW.'reportar_pago.php'); 