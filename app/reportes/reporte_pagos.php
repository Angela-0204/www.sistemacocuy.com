<?php
require_once('../../vendor/autoload.php'); // Asegúrate de que la ruta sea correcta para cargar TCPDF
include('../../app/config.php');
include('../../'.$MODELS . 'reporte_pago.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ReporteExcel
{
    public function generarReporteDescargable($datos, $nombreArchivo = 'reporte.xlsx')
    {
        // Crear un nuevo documento de Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Verificar si los datos no están vacíos
        if (empty($datos)) {
            echo "No se encontraron datos para mostrar en el reporte.";
            exit;
        }

        // Agregar encabezados (primer fila con los nombres de las columnas)
        $encabezados = array_keys($datos[0]); // Tomamos las claves del primer registro como encabezados
        $columna = 'A';
        foreach ($encabezados as $encabezado) {
            $sheet->setCellValue($columna . '1', $encabezado);
            // Estilo para los encabezados: Negrita y fondo
            $sheet->getStyle($columna . '1')->getFont()->setBold(true);
            $sheet->getStyle($columna . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($columna . '1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($columna . '1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($columna . '1')->getFill()->getStartColor()->setRGB('F0F0F0'); // Gris claro
            $columna++;
        }

        // Ajustar el ancho de las columnas automáticamente
        $columnWidths = []; // Para almacenar el máximo de caracteres por columna

        // Agregar los datos en las filas
        $fila = 2; // Empezamos a agregar los datos a partir de la segunda fila
        foreach ($datos as $dato) {
            $columna = 'A';
            foreach ($dato as $key => $valor) {
                // Si la clave es 'Fecha', formatear el valor
                if ($key === 'Fecha') {
                    $valor = date('d-m-Y H:i:s', strtotime($valor)); // Formato deseado
                }
        
                // Asignar el valor a la celda
                $sheet->setCellValue($columna . $fila, $valor);
        
                // Ajustar el ancho de la columna dependiendo de la longitud del texto
                $currentWidth = strlen($valor);
                if (!isset($columnWidths[$columna]) || $columnWidths[$columna] < $currentWidth) {
                    $columnWidths[$columna] = $currentWidth; // Actualizamos el ancho de la columna si es mayor
                }
        
                $columna++;
            }
            $fila++;
        }
        

        // Ajustar el ancho de las columnas a los valores almacenados en $columnWidths (en unidades aproximadas de 1 carácter)
        foreach ($columnWidths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width + 5); // Añadir un pequeño margen
        }

        // Establecer un ancho fijo de 15cm para todas las columnas (aproximadamente 56 caracteres)
        // Puedes modificar esta línea si necesitas un ancho más específico o diferente para cada columna.
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setWidth(15); // Establecer un ancho fijo de 15 caracteres
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

// Primero instanciar la clase Reporte_pago que contiene el método Listar
$reporte_pago = new Reporte_pago();
$parametro = $_GET['parametro'];
if($parametro=="false"){
    $datosReporte = $reporte_pago->GenerarReporte();
}
else{
    $tipo_pago = $_GET['tipo_pago'];
    $datosReporte = $reporte_pago->GenerarReportePorMetodo($tipo_pago);
}

// Verificar que se haya obtenido algún dato
if ($datosReporte) {
    // Instanciar la clase ReporteExcel para generar el archivo
    $reporteExcel = new ReporteExcel();
    
    // Llamar al método para descargar el archivo
    $reporteExcel->generarReporteDescargable($datosReporte, 'reporte_pago.xlsx');
} else {
    echo "No hay datos disponibles para generar el reporte.";
}
