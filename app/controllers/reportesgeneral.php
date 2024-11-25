<?php
include('app/config.php');
include($MODELS . 'producto.php');

// Inicia sesión 
session_start();
// Verificar si la sesión está activa
if (!isset($_SESSION['id_user'])) {
    // Si no está iniciada la sesión, redirigir al login
    header('Location: ?pagina=login');
    exit();  // Asegura que no se ejecute el código restante de la página
}

// Verificar si se ha enviado un reporte mediante AJAX
if (isset($_GET['reporte'])) {
    $reporte = $_GET['reporte'];
    if ($reporte == 'inventario_general') {
        // Generar el PDF y devolver la URL para abrir el archivo
        $pdfFilePath = 'app/reportes/reporte_inventario.php';

        // Verifica si el archivo existe
        if (file_exists($pdfFilePath)) {
            echo json_encode([
                "estatus" => 1,
                "url" => $pdfFilePath."?fechas=false"
            ]);
        } else {
            echo json_encode([
                "estatus" => 0,
                "mensaje" => "Error al generar el PDF."
            ]);
        }
        exit;

    }
    if ($reporte == 'inventario_rangos') {
        // Generar el PDF y devolver la URL para abrir el archivo
        $pdfFilePath = 'app/reportes/reporte_inventario.php';
        $fecha_desde = $_GET['fecha_desde'];
        $fecha_hasta = $_GET['fecha_hasta'];

        // Verifica si el archivo existe
        if (file_exists($pdfFilePath)) {
            echo json_encode([
                "estatus" => 1,
                "url" => $pdfFilePath."?fechas=true&fecha_desde=".$fecha_desde."&fecha_hasta=".$fecha_hasta
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

        
    } 

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
    if ($reporte == 'reporte_pagos') {
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
    
    
    
    else {
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
