<?php
include('app/config.php');
include($MODELS . 'producto.php');
include($MODELS . 'categoria.php');
include($MODELS . 'caja.php');
include($MODELS . 'marcas.php');
$producto = new Producto();
$categoria = new Categoria();
$caja = new Caja();
$marcas = new Marcas();

//Para listar categorias en los selects
$data_categorias = $categoria->Listar();
$data_cajas = $caja->Listar();
$data_marcas = $marcas->Listar();
session_start();
// Verificar si la sesión está activa
if (!isset($_SESSION['id_user']) || $_SESSION['rol']!= 1) {
    // Si no está iniciada la sesión, redirigir al login
    header('Location: ?pagina=login');
    exit();  // Asegura que no se ejecute el código restante de la página
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'registrar':
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $id_categoria = $_POST['categoria'];
            $id_marca = $_POST['marca'];
            $fecha_creacion = $_POST['fecha'];
    
            // Procesar la imagen
            $imagen = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = basename($_FILES['imagen']['name']);
                $rutaImagen = 'img/productos/' . $nombreImagen;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                    $imagen = $rutaImagen;
                }
            }
    
            $fyh_actualizacion = date('Y-m-d H:i:s');
    
            // Recoger detalles de producto
            $detalles = isset($_POST['detalles']) ? $_POST['detalles'] : [];
            if (!is_array($detalles) || empty($detalles)) {
                echo json_encode(['estatus' => 0, 'mensaje' => "Detalles de producto no válidos."]);
                exit;
            }
            
            // Enviar datos a la función Crear
            $result = $producto->Crear(
                $nombre,
                $descripcion,
                $id_categoria,
                $id_marca,
                $imagen,
                $fecha_creacion,
                $fyh_actualizacion,
                $detalles
            );
    
            // Respuesta
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Producto registrado exitosamente.";
                $respuesta['icon'] = 'success';
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al registrar el producto.";
                $respuesta['icon'] = 'error';
            }
    
            header("Content-Type: application/json");
            echo json_encode($respuesta);
            exit;
    }
    
}

// Solo incluye la vista si no es una solicitud de acción
if (!isset($_POST['accion'])) {
    include($VIEW . 'producto/agregar.php');
}
?>
