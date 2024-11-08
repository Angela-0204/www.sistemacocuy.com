<?php
require_once('../../vendor/autoload.php'); // Asegúrate de que la ruta sea correcta para cargar TCPDF
include('../../app/config.php');
include('../../'.$MODELS . 'pedido.php');
$pedido = new Pedido();
session_start();

// Obtener el id del pedido (lo pasamos por GET)
$id_pedido = isset($_GET['id_pedido']) ? $_GET['id_pedido'] : null;
$data_pedido = $pedido->ConsultarPedido($id_pedido);

// Verificar si los datos existen
if (isset($data_pedido['error'])) {
    die("Error: " . $data_pedido['error']);
}

// Asegurarse de que los datos del pedido y los detalles estén disponibles
$pedido_data = $data_pedido['pedido']; // Accedemos al pedido
$detalles_data = $data_pedido['detalles']; // Accedemos a los detalles
$total_pedido = $data_pedido['total']; // Total del pedido

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Empresa');
$pdf->SetTitle('Detalles del Pedido');
$pdf->SetSubject('Factura del Pedido');

// Márgenes y auto salto de página
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Establecer la fuente
$pdf->SetFont('helvetica', '', 12);

// Título del pedido
$pdf->Cell(0, 10, 'Detalles del Pedido', 0, 1, 'C');
$pdf->Ln(5);

// Agregar los datos del pedido
$pdf->Cell(50, 10, 'Cod. del Pedido: A-000' . $pedido_data['id_pedido']);
$pdf->Ln(10);
$pdf->Cell(50, 10, 'Cliente: ' . $pedido_data['nombre_cliente']);
$pdf->Ln(10);
$pdf->Cell(50, 10, 'Fecha del Pedido: ' . date('d/m/Y', strtotime($pedido_data['fecha_pedido'])));
$pdf->Ln(10);

// Detalle del pedido
$pdf->Cell(50, 10, 'Producto', 1, 0, 'C');
$pdf->Cell(50, 10, 'Descripción', 1, 0, 'C');
$pdf->Cell(30, 10, 'Precio Unitario', 1, 0, 'C');
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 10, 'Subtotal', 1, 1, 'C');

// Productos del pedido
foreach ($detalles_data as $producto) {
    $subtotal = $producto['precio_venta'] * $producto['cantidad'];
    $pdf->Cell(50, 10, $producto['producto_nombre'], 1, 0, 'C');
    $pdf->Cell(50, 10, $producto['producto_descripcion'], 1, 0, 'C');
    $pdf->Cell(30, 10, '$' . number_format($producto['precio_venta'], 2), 1, 0, 'C');
    $pdf->Cell(30, 10, $producto['cantidad'], 1, 0, 'C');
    $pdf->Cell(30, 10, '$' . number_format($subtotal, 2), 1, 1, 'C');
}

// Total del pedido
$pdf->Ln(10);
$pdf->Cell(140, 10, 'Total Pedido', 1, 0, 'C');
$pdf->Cell(30, 10, '$' . number_format($total_pedido, 2), 1, 1, 'C');

// Salida del PDF
$pdf->Output('pedido_' . $id_pedido . '.pdf', 'I'); // Muestra el PDF en el navegador

?>
