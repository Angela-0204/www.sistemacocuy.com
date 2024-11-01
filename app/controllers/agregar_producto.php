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

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'registrar':
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $id_categoria = $_POST['categoria'];
            $stock = $_POST['stock'];
            $precio_venta = $_POST['precio'];
            $fecha_creacion = $_POST['fecha'];
            $id_empaquetado = $_POST['caja'];
            $marca = $_POST['marca'];
            $lote = $_POST['lote'];
            $estatus = $_POST['estatus'];

            // Manejar la subida de la imagen
            $imagen = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = basename($_FILES['imagen']['name']);
                $rutaImagen = 'img/productos/' . $nombreImagen;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                    $imagen = $rutaImagen;
                }
            }

            $fyh_actualizacion = date('Y-m-d H:i:s');

            $result = $producto->Crear($nombre, $descripcion, $id_categoria, $stock, $precio_venta, $imagen, $fecha_creacion, $fyh_actualizacion, $id_empaquetado, $marca, $lote, $estatus);

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
            exit; // Finalizar el script
    }
}

// Solo incluye la vista si no es una solicitud de acción
if (!isset($_POST['accion'])) {
    include($VIEW . 'producto/agregar.php');
}
?>
