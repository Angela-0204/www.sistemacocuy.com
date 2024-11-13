<?php
require_once('../../vendor/autoload.php'); // Asegúrate de que la ruta sea correcta para cargar TCPDF

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteExcel
{
    public function generarReporteDescargable($datos, $nombreArchivo = 'reporte.xlsx')
    {
        // Crear un nuevo documento de Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Agregar encabezados
        $encabezados = array_keys($datos[0]);
        $columna = 'A';
        foreach ($encabezados as $encabezado) {
            $sheet->setCellValue($columna . '1', $encabezado);
            $columna++;
        }

        // Agregar los datos en las filas
        $fila = 2;
        foreach ($datos as $dato) {
            $columna = 'A';
            foreach ($dato as $valor) {
                $sheet->setCellValue($columna . $fila, $valor);
                $columna++;
            }
            $fila++;
        }

        // Enviar el archivo Excel al navegador para que se descargue
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
        header('Cache-Control: max-age=0');

        // Crear el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit; // Terminar el script para que solo descargue el archivo
    }
}

// Ejemplo de uso
$reporte = new ReporteExcel();

// Datos de ejemplo para el reporte
$datos = [
    ['ID' => 1, 'Nombre' => 'Producto A', 'Cantidad' => 10, 'Precio' => 50.00],
    ['ID' => 2, 'Nombre' => 'Producto B', 'Cantidad' => 5, 'Precio' => 100.00],
    ['ID' => 3, 'Nombre' => 'Producto C', 'Cantidad' => 2, 'Precio' => 150.00],
];

// Llamar al método para descargar el archivo
$reporte->generarReporteDescargable($datos);
