<?php
// Incluye TCPDF y las configuraciones necesarias
require_once('../../vendor/autoload.php'); // Asegúrate de que la ruta sea correcta para cargar TCPDF
include('../../app/config.php');

include('../../'.$MODELS . 'pedido.php');



$pedido = new Pedido();
$listar = $pedido->Listar();


// Crea una instancia de TCPDF
$pdf = new TCPDF();

// Configuración del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del Autor');
$pdf->SetTitle('Reporte de Pedidos');
$pdf->SetSubject('Reporte');
$pdf->SetKeywords('TCPDF, PDF, report, test, guide');

// Configura las márgenes
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Configura el título
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Pedidos', 0, 1, 'C');
$pdf->Ln(10);

// Encabezados de la tabla
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(30, 10, 'Código De Pedido', 1, 0, 'C');
$pdf->Cell(40, 10, 'Fecha del Pedido', 1, 0, 'C');
$pdf->Cell(60, 10, 'Estatus', 1, 0, 'C');
$pdf->Cell(20, 10, 'Cliente', 1, 0, 'C');
$pdf->Cell(20, 10, 'Cantidad', 1, 0, 'C');
$pdf->Ln();

// Llenado de datos en la tabla
$pdf->SetFont('helvetica', '', 9);
foreach ($listar as $product) {
    $pdf->Cell(30, 10, $product['id_pedido'], 1, 0, 'C');
    $pdf->Cell(40, 10, $product['fecha_pedido'], 1, 0, 'L');
    $pdf->Cell(60, 10, $product['nombre_cliente'], 1, 0, 'L');
    $pdf->Cell(20, 10, 3, 1, 0, 'C');
    $pdf->Cell(20, 10, '$' . 3, 1, 0, 'R');
    $pdf->Ln();
}

// Cierra y envía el archivo al navegador para descargar o mostrar
$pdf->Output('reporte_pedido.pdf', 'I');
?>
