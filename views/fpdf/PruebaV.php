<?php

require('./fpdf.php');

class PDF extends FPDF
{
   // Cabecera de página
   function Header()
   {
      include '../../app/connectDB.php'; // Connection to the database

      $consulta_info = $conexion->query("SELECT * FROM inventario"); // Fetch data from the database
      $dato_info = $consulta_info->fetch_object();
      $this->Image('logo1.jpg', 185, 5, 20); // Logo of the company
      $this->SetFont('Arial', 'B', 19); // Set font type, bold, size
      $this->Cell(45); // Move to the right
      $this->SetTextColor(0, 0, 0); // Set text color
      // Create a cell or row
      $this->Cell(110, 15, utf8_decode('COCUY LEAL'), 0, 1, 'C', 0); // Cell for the title
      $this->Ln(3); // Line break
      $this->SetTextColor(103); // Set text color

      // Additional information about location, phone, email, etc.
      $this->Cell(110);  // Move to the right
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(96, 10, utf8_decode("Ubicación : "), 0, 0, '', 0);
      $this->Ln(5);

      $this->Cell(110);  // Move to the right
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10, utf8_decode("Teléfono : "), 0, 0, '', 0);
      $this->Ln(5);

      $this->Cell(110);  // Move to the right
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Correo : "), 0, 0, '', 0);
      $this->Ln(5);

      $this->Cell(110);  // Move to the right
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Sucursal : "), 0, 0, '', 0);
      $this->Ln(10);

      // Title of the table
      $this->SetTextColor(228, 100, 0);
      $this->Cell(50); // Move to the right
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE INVENTARIO"), 0, 1, 'C', 0);
      $this->Ln(7);

      // Table headers
      $this->SetFillColor(228, 100, 0); // Background color
      $this->SetTextColor(255, 255, 255); // Text color
      $this->SetDrawColor(163, 163, 163); // Border color
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(18, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
      $this->Cell(70, 10, utf8_decode('DESCRIPCIÓN'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('PRECIO'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('CATEGORÍA'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('ESTADO'), 1, 1, 'C', 1);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Position at 1.5 cm from the bottom
      $this->SetFont('Arial', 'I', 8); // Set font type, italic, size
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); // Page footer (page number)

      $this->SetY(-15); // Position at 1.5 cm from the bottom
      $this->SetFont('Arial', 'I', 8); // Set font type, italic, size
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // Page footer (date)
   }
}

// Create a new PDF document
$pdf = new PDF();
$pdf->AddPage(); // Add a new page
$pdf->AliasNbPages(); // Show page number and total pages

$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); // Border color

// Query to fetch all inventory items
$consulta_reporte_inventario = $conexion->query("SELECT cod_inventario, nombre, descripcion, id_categoria, precio_venta FROM inventario");
$i = 0;

// Loop through the results and create table rows
while ($datos_reporte = $consulta_reporte_inventario->fetch_object()) {
    $i++;
    $pdf->Cell(18, 10, utf8_decode($i), 1, 0, 'C', 0);
    $pdf->Cell(20, 10, utf8_decode($datos_reporte->nombre), 1, 0, 'C', 0);
    $pdf->Cell(70, 10, utf8_decode($datos_reporte->descripcion), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, utf8_decode("$" . number_format($datos_reporte->precio_venta, 2)), 1, 0, 'C', 0);
    
    // Fetch category name
    $categoria = $conexion->query("SELECT nombre FROM categoria WHERE id_categoria = " . $datos_reporte->id_categoria);
    $cat_data = $categoria->fetch_object();
    $pdf->Cell(30, 10, utf8_decode($cat_data->nombre), 1, 0, 'C', 0);
    
    $pdf->Cell(25, 10, utf8_decode('Disponible'), 1, 1, 'C', 0); // Assuming all items are available
}

// Output the PDF
$pdf->Output('inventario.pdf', 'I'); // Output the PDF to the browser
?>
