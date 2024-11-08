<?php
// Incluye TCPDF y las configuraciones necesarias
require_once('../../vendor/autoload.php'); // Asegúrate de que la ruta sea correcta para cargar TCPDF
include('../../app/config.php');
include('../../'.$MODELS . 'producto.php');

// Obtiene los datos de productos
$producto = new Producto();
$data_products = $producto->Listar();

// Crea una instancia de TCPDF
$pdf = new TCPDF();

// Configuración del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del Autor');
$pdf->SetTitle('Reporte de Inventario');
$pdf->SetSubject('Reporte');
$pdf->SetKeywords('TCPDF, PDF, report, test, guide');

// Configura las márgenes
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Configura el título
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Inventario', 0, 1, 'C');
$pdf->Ln(10);

// Encabezados de la tabla
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(30, 10, 'Código', 1, 0, 'C');
$pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(60, 10, 'Descripción', 1, 0, 'C');
$pdf->Cell(20, 10, 'Stock', 1, 0, 'C');
$pdf->Cell(20, 10, 'Precio', 1, 0, 'C');
$pdf->Ln();

// Llenado de datos en la tabla
$pdf->SetFont('helvetica', '', 9);
foreach ($data_products as $product) {
    $pdf->Cell(30, 10, $product['cod_inventario'], 1, 0, 'C');
    $pdf->Cell(40, 10, $product['nombre'], 1, 0, 'L');
    $pdf->Cell(60, 10, $product['descripcion'], 1, 0, 'L');
    $pdf->Cell(20, 10, $product['stock'], 1, 0, 'C');
    $pdf->Cell(20, 10, '$' . $product['precio_venta'], 1, 0, 'R');
    $pdf->Ln();
}

// Cierra y envía el archivo al navegador para descargar o mostrar
$pdf->Output('reporte_inventario.pdf', 'I');
?>
