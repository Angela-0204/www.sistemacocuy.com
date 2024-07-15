<?php
include('app/config.php');
include($MODELS . 'producto.php');
include($MODELS . 'categoria.php');
include($MODELS . 'caja.php');
include ($MODELS . 'presentacion.php');
$producto = new Producto();
$categoria = new Categoria();
$caja = new Caja();
$presentacion = new Presentacion();
//Para listar categorias en los selects
$data_categorias = $categoria->Listar();
$data_cajas = $caja->Listar();
$data_presentacion = $presentacion->Listar();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $id_categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $stock_minimo = $_POST['stock_minimo'];
    $stock_maximo = $_POST['stock_maximo'];
    $precio_venta = $_POST['precio'];
    $fecha_ingreso = $_POST['fecha'];
    $id_caja = $_POST['caja'];
    $presentacion = $_POST['litraje']; 

    // Manejar la subida de la imagen
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaImagen = 'img/productos/' . $nombreImagen;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            $imagen = $rutaImagen;
        }
    }

    $fyh_creacion = date('Y-m-d H:i:s');
    $fyh_actualizacion = date('Y-m-d H:i:s');

    $result = $producto->Crear($codigo, $nombre, $descripcion, $id_categoria, $stock, $stock_minimo, $stock_maximo, $precio_venta, $imagen, $fyh_creacion, $fyh_actualizacion, $id_caja, $litraje);
    
    $response = array();
    if ($result) {
        $response['estatus'] = 1;
        $response['mensaje'] = "Producto registrado exitosamente.";
    } else {
        $response['estatus'] = 0;
        $response['mensaje'] = "Error al registrar el producto.";
    }
    
    echo json_encode($response);
    return 0;
}

include($VIEW.'producto/agregar.php'); 
?>
