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

// Para listar categorías, cajas y marcas en los selects
$data_categorias = $categoria->Listar();
$data_cajas = $caja->Listar();
$data_marcas = $marcas->Listar();

session_start();

// Verificar si recibimos el id del producto a editar
if (isset($_GET['id'])) {
    $cod_inventario = $_GET['id'];

    // Obtener datos principales del producto usando el id
    $productoData = $producto->ObtenerProductoPorId($cod_inventario);

    // Si no se encuentra el producto, redirigir a una página de error o mostrar un mensaje
    if (!$productoData) {
        echo "Producto no encontrado.";
        exit;
    }

    // Obtener los detalles de inventario asociados al producto
    $detallesInventario = $producto->ObtenerDetallesInventario($cod_inventario);
}

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'modificar':
            // Recoger los datos del formulario
            $cod_inventario = $_GET['id'];
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
    
            // Recoger detalles del inventario
            // Aquí vamos a decodificar la cadena JSON que enviamos desde el cliente
            $detalles = isset($_POST['detalles']) ? json_decode($_POST['detalles'], true) : [];    
            if (!is_array($detalles) || empty($detalles)) {
                header("Content-Type: application/json");
                echo json_encode(['estatus' => 0, 'mensaje' => "Detalles de producto no válidos."]);
                exit;
            }
    
            // Llamar al método Modificar en el modelo
            $result = $producto->Modificar(
                $cod_inventario, 
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
                $respuesta['mensaje'] = "Producto modificado exitosamente.";
                $respuesta['icon'] = 'success';
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar el producto.";
                $respuesta['icon'] = 'error';
            }
    
            header("Content-Type: application/json");
            echo json_encode($respuesta);
            exit;
    }
    
}


// Solo incluye la vista si no es una solicitud de acción
if (!isset($_POST['accion'])) {
    include($VIEW . 'producto/editar.php');
}
