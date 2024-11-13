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
$pdf->Cell(25, 10, 'Cód. Pedido', 1, 0, 'C');
$pdf->Cell(50, 10, 'Fecha del Pedido', 1, 0, 'C');
$pdf->Cell(70, 10, 'Cliente', 1, 0, 'C');
$pdf->Cell(20, 10, 'Estatus', 1, 0, 'C');
/*$pdf->Cell(20, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(40, 10, 'Producto', 1, 0, 'C');
$pdf->Cell(30, 10, 'Categoria', 1, 0, 'C');
$pdf->Cell(20, 10, 'Marca', 1, 0, 'C');*/
$pdf->Ln();

//p.id_pedido, p.fecha_pedido, c.nombre_cliente, c.apellido, p.estatus
// Llenado de datos en la tabla
$pdf->SetFont('helvetica', '', 9);
foreach ($listar as $product) {
    $activo = $product['estatus'] == 1 ? 'Activo': 'Anulado';
    $pdf->Cell(25, 10, "A-000".$product['id_pedido'], 1, 0, 'C');
    $pdf->Cell(50, 10, $product['fecha_pedido'], 1, 0, 'C');
    $pdf->Cell(70, 10, $product['nombre_cliente'].' '.$product['apellido'], 1, 0, 'C');
    $pdf->Cell(20, 10, $activo, 1, 0, 'C');
    /*$pdf->Cell(40, 10, $product['nombre'], 1, 0, 'C');
    $pdf->Cell(30, 10, $product['nombre_categoria'], 1, 0, 'C');
    $pdf->Cell(20, 10, $product['marca'], 1, 0, 'C');*/
    
   
    $pdf->Ln();
}

// Cierra y envía el archivo al navegador para descargar o mostrar
$pdf->Output('reporte_pedido.pdf', 'I');
?>
