<?php
include('app/config.php');
include($MODELS . 'producto.php');
include($MODELS . 'categoria.php');
$producto = new Producto();
$categoria = new Categoria();

//Para listar categorias en los selects
$data_categorias = $categoria->Listar();

//Para listar los productos
$data_products = $producto->Listar();
session_start();

//Para consultar el registro
if(isset($_GET['id']) && !empty($_GET['id']) && !isset($_POST['modificar'])){
    $data = $producto->Buscar($_GET['id']);
    require_once($VIEW.'/producto/editar.php'); 
    return 0;
}

//Para eliminar registro
if(isset($_POST['eliminar']) && !empty($_POST['eliminar'])){
    $result = $producto->Eliminar($_POST['id']);
    $respuesta = array();
    if ($result) {
        $respuesta['estatus'] = 1;
        $respuesta['mensaje'] = "Producto Eliminado exitosamente.";
    } else {
        $respuesta['estatus'] = 0;
        $respuesta['mensaje'] = "Error al eliminar el producto.";
    }
    echo json_encode($respuesta);
    return 0;
}


//Para modificar un registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $id_categoria = $_POST['categoria'];
    $stock_minimo = $_POST['stock_minimo'];
    $stock_maximo = $_POST['stock_maximo'];
    $precio_venta = $_POST['precio'];

    // Manejar la subida de la imagen
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaImagen = 'img/productos/' . $nombreImagen;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            $imagen = $rutaImagen;
        }
    }

    $result = $producto->Modificar($id, $codigo, $nombre, $descripcion, $id_categoria, $stock_minimo, $stock_maximo, $precio_venta, $imagen);
    $respuesta = array();
    if ($result) {
        $respuesta['estatus'] = 1;
        $respuesta['mensaje'] = "Producto Modificado exitosamente.";
    } else {
        $respuesta['estatus'] = 0;
        $respuesta['mensaje'] = "Error al modificar el producto.";
    }
    echo json_encode($respuesta);
    return 0;
}

include($VIEW.'inventario.php'); 
?>