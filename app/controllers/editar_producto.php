<?php
include('app/config.php');
include($MODELS . 'producto.php');
include($MODELS . 'categoria.php');
include($MODELS . 'caja.php');
include($MODELS . 'marcas.php');
include($MODELS . 'medida.php');

$ml = new Medida();
$producto = new Producto();
$categoria = new Categoria();
$caja = new Caja();
$marcas = new Marcas();


// Para listar categorías, cajas y marcas en los selects
$data_categorias = $categoria->Listar();
$data_cajas = $caja->Listar();
$data_marcas = $marcas->Listar();
$data_medida = $ml->Listar();
session_start();
// Verificar si la sesión está activa
if (!isset($_SESSION['id_user']) || $_SESSION['rol']!= 1) {
    // Si no está iniciada la sesión, redirigir al login
    header('Location: ?pagina=login');
    exit();  // Asegura que no se ejecute el código restante de la página
}

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
            $fyh_actualizacion = $_POST['fecha'];
    
            // Procesar la imagen
            $imagen = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = basename($_FILES['imagen']['name']);
                $rutaImagen = 'img/productos/' . $nombreImagen;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                    $imagen = $rutaImagen;
                }
            }
    
    
            // Llamar al método Modificar en el modelo
            $result = $producto->Modificar(
                $cod_inventario, 
                $nombre, 
                $descripcion, 
                $id_categoria, 
                $fyh_actualizacion
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
        break;
        case 'eliminar_detalle':
            $id_detalle_inventario = $_POST['id_detalle_inventario'];

            // Llamar al método de eliminación en el modelo
            $result = $producto->EliminarDetalle($id_detalle_inventario);
        
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Detalle eliminado correctamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar el detalle.";
            }
        
            echo json_encode($respuesta);
            exit;
        break;
        case 'guardar_detalle':
            $id_detalle_inventario = $_POST['id_detalle_inventario'];
            $stock = $_POST['stock'];
            $lote = $_POST['lote'];
            $precio = $_POST['precio'];
            $estatus = $_POST['estatus'];

            // Llamar al método para actualizar el detalle en el modelo
            $result = $producto->GuardarDetalle($id_detalle_inventario, $stock, $lote, $precio, $estatus);

            if ($result) {
                echo json_encode([
                    'estatus' => 1,
                    'mensaje' => "Cambios guardados correctamente."
                ]);
            } else {
                echo json_encode([
                    'estatus' => 0,
                    'mensaje' => "Error al guardar el detalle."
                ]);
            }
            exit;
        break;
        case 'nuevo_detalle':
            $cod_inventario = $_GET['id'];
            $empaquetadoId = $_POST['empaquetadoId'];
            $stock = $_POST['stock'];
            $lote = $_POST['lote'];
            $precio = $_POST['precio'];
            $estatus = $_POST['estatus'];
            $cod_unidad = $_POST['medida'];
        
            // Llamar al método para insertar el nuevo detalle
            $result = $producto->NuevoDetalle($cod_inventario, $empaquetadoId, $stock, $lote, $precio, $cod_unidad, $estatus);
        
            // Verificar el resultado devuelto por la función
            if ($result['estatus'] == 1) {
                echo json_encode([
                    'estatus' => 1,
                    'mensaje' => "Nuevo detalle del producto creado exitosamente."
                ]);
            } else {
                echo json_encode([
                    'estatus' => 0,
                    'mensaje' => $result['mensaje']  // Aquí usamos el mensaje que devuelve el método
                ]);
            }
            exit;
        break;
        
    }
    
}


// Solo incluye la vista si no es una solicitud de acción
if (!isset($_POST['accion'])) {
    include($VIEW . 'producto/editar.php');
}
