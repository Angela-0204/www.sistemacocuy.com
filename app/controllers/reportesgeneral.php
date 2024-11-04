<?php
include('app/config.php');
include($MODELS . 'producto.php');

// Inicia sesión 
session_start();

// Verificar si se ha enviado un reporte mediante AJAX
if (isset($_GET['reporte'])) {
    $reporte = $_GET['reporte'];
    if ($reporte == 'reporte_pedido') {
        // Generar el PDF y devolver la URL para abrir el archivo
        $pdfFilePath = 'app/reportes/'.$reporte.'.php';

        // Verifica si el archivo existe
        if (file_exists($pdfFilePath)) {
            echo json_encode([
                "estatus" => 1,
                "url" => $pdfFilePath
            ]);
        } else {
            echo json_encode([
                "estatus" => 0,
                "mensaje" => "Error al generar el PDF."
            ]);
        }
        exit;
    }
    if ($reporte == 'reporte_clientes') {
        // Generar el PDF y devolver la URL para abrir el archivo
        $pdfFilePath = 'app/reportes/'.$reporte.'.php';

        // Verifica si el archivo existe
        if (file_exists($pdfFilePath)) {
            echo json_encode([
                "estatus" => 1,
                "url" => $pdfFilePath
            ]);
        } else {
            echo json_encode([
                "estatus" => 0,
                "mensaje" => "Error al generar el PDF."
            ]);
        }
        exit;
    } else {
        // Respuesta en caso de que el reporte solicitado no exista
        echo json_encode([
            "estatus" => 0,
            "mensaje" => "Tipo de reporte no válido."
        ]);
    }
    exit;
}

include($VIEW.'reportesgeneral.php'); 

?>
