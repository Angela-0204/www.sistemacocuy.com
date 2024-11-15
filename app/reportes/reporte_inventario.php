<?php
// el archivo que viene del composer
require_once('../../vendor/autoload.php'); 
include('../../app/config.php');
include('../../'.$MODELS . 'producto.php');

// obtener datos de la BD
$producto = new Producto();
$data_products = $producto->ListarDesgloce();

//libreria para el pdf
$pdf = new TCPDF('L'); 


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del Autor');
$pdf->SetTitle('Reporte de Inventario');
$pdf->SetSubject('Reporte');
$pdf->SetKeywords('TCPDF, PDF, report, test, guide');


$pdf->SetMargins(8.5, 20, 20);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage(); 


$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Inventario', 0, 1, 'C');
$pdf->Ln(10);


$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(80, 10, 'Descripción', 1, 0, 'C');
$pdf->Cell(30, 10, 'Categoría', 1, 0, 'C');
$pdf->Cell(30, 10, 'Marca', 1, 0, 'C');
$pdf->Cell(25, 10, 'Ud. Medida', 1, 0, 'C');
$pdf->Cell(25, 10, 'Empaquetado', 1, 0, 'C');
$pdf->Cell(20, 10, 'Stock', 1, 0, 'C');
$pdf->Cell(20, 10, 'Precio', 1, 0, 'C');
$pdf->Ln();


$pdf->SetFont('helvetica', '', 9);
foreach ($data_products as $product) {
    $pdf->Cell(50, 10, $product['producto_nombre'], 1, 0, 'C');
    $pdf->Cell(80, 10, $product['producto_descripcion'], 1, 0, 'C');
    $pdf->Cell(30, 10, $product['categoria'], 1, 0, 'C');
    $pdf->Cell(30, 10, $product['marca'], 1, 0, 'C');
    $pdf->Cell(25, 10, $product['unidad_medida'], 1, 0, 'C');
    $pdf->Cell(25, 10, $product['cantidad_empaquetado'], 1, 0, 'C');
    $pdf->Cell(20, 10, $product['stock'], 1, 0, 'C');
    $pdf->Cell(20, 10, '$' . number_format($product['precio'], 2), 1, 0, 'C');
    $pdf->Ln();
}


$pdf->Output('reporte_inventario.pdf', 'I');
?>
