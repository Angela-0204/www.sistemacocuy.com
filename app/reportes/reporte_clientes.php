<?php
// Incluye TCPDF y las configuraciones necesarias
require_once('vendor/autoload.php'); // Asegúrate de que la ruta sea correcta para cargar TCPDF
include('app/config.php');
include($MODELS . 'cliente.php');

$cliente = new Cliente();
$data_cliente = $cliente->Listar();

// Crea una instancia de TCPDF
$pdf = new TCPDF();

// Configuración del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nombre del Autor');
$pdf->SetTitle('Reporte de Clientes');
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
$pdf->Cell(30, 10, 'Cedula o RIF', 1, 0, 'C');
$pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(60, 10, 'Apellido', 1, 0, 'C');
$pdf->Cell(20, 10, 'Direccion', 1, 0, 'C');
$pdf->Cell(20, 10, 'Correo', 1, 0, 'C');
$pdf->Cell(20, 10, 'Telefono', 1, 0, 'C');
$pdf->Cell(20, 10, 'Esatus', 1, 0, 'C');
$pdf->Ln();

// Llenado de datos en la tabla
$pdf->SetFont('helvetica', '', 9);
foreach ($data_cliente as $cliente) {
    $pdf->Cell(30, 10, $cliente['cedula_rif'], 1, 0, 'C');
    $pdf->Cell(40, 10, $cliente['nombre_cliente'], 1, 0, 'L');
    $pdf->Cell(60, 10, $cliente['apellido'], 1, 0, 'L');
    $pdf->Cell(20, 10, $cliente['direccion'], 1, 0, 'C');
    $pdf->Cell(20, 10, $cliente['correo'], 1, 0, 'C');
    $pdf->Cell(20, 10, $cliente['telefono'], 1, 0, 'C');
    $pdf->Cell(20, 10, $cliente['estatus'], 1, 0, 'C');
    $pdf->Ln();
}

// Cierra y envía el archivo al navegador para descargar o mostrar
$pdf->Output('reporte_clientes.pdf', 'I');
?>
