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
$data_pedido = $pedido->Listar();
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
           
           
            $nro_pago = $_POST ['nro_pago'];
            
             $monto = $_POST ['monto'];
            $referencia = $_POST ['referencia'];

             $fyh_pago = $_POST['fyh_pago'];
             $id_banco = $_POST ['id_banco'];
             $id_pedido = $_POST ['id_pedido'];
            
        
             $result = $reporte->Crear($fyh_pago, $monto, $nro_pago,  $referencia, $id_banco, $id_pedido);


            
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

   
    }
}


include($VIEW.'reportar_pago.php'); 
?>