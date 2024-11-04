<?php
// Incluye TCPDF y las configuraciones necesarias

require_once('../../vendor/autoload.php'); // Asegúrate de que la ruta sea correcta para cargar TCPDF
include('../../app/config.php');
include('../../'.$MODELS . 'cliente.php');
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
$pdf->SetMargins(10, 20, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Configura el título
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Clientes', 0, 1, 'C');
$pdf->Ln(10);

// Encabezados de la tabla
$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(30, 10, 'Identificación', 1, 0, 'C');
$pdf->Cell(30, 10, 'Nombre y Apellido', 1, 0, 'C');
$pdf->Cell(50, 10, 'Direccion', 1, 0, 'C');
$pdf->Cell(45, 10, 'Correo', 1, 0, 'C');
$pdf->Cell(20, 10, 'Telefono', 1, 0, 'C');
$pdf->Cell(20, 10, 'Estatus', 1, 0, 'C');
$pdf->Ln();

// Llenado de datos en la tabla
$pdf->SetFont('helvetica', '', 8);
foreach ($data_cliente as $cliente) {
    $pdf->Cell(30, 10, $cliente['cedula_rif'], 1, 0, 'C');
    $pdf->Cell(30, 10, $cliente['nombre_cliente'].' '.$cliente['apellido'], 1, 0, 'C');
    $pdf->Cell(50, 10, $cliente['direccion'], 1, 0, 'C');
    $pdf->Cell(45, 10, $cliente['correo'], 1, 0, 'C');
    $pdf->Cell(20, 10, $cliente['telefono'], 1, 0, 'C');
    $pdf->Cell(20, 10, $cliente['estatus'], 1, 0, 'C');
    $pdf->Ln();
}

// Cierra y envía el archivo al navegador para descargar o mostrar
$pdf->Output('reporte_clientes.pdf', 'I');
?>
