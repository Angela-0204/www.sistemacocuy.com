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
//Para listar los productos
$data_products = $producto->Listar();
session_start();

//Para listar categorias en los selects

$data_categorias = $categoria->Listar();
$data_cajas = $caja->Listar();
$data_marcas = $marcas->Listar();

//Para modificar un registro
if(isset($_POST['accion'])){
    switch($_POST['accion']){  
        //Para consultar el registro a modificar
        case 'consultar':
            $data = $producto->Buscar($_POST['id_producto']);
            echo json_encode($data[0]);
            return 0;
        break;
        case 'modificar':
            $cod_inventario = $_POST['cod_inventario'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $id_categoria = $_POST['categoria'];
            $precio_venta = $_POST['precio'];
            $fyh_actualizacion = $_POST['fecha'];
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

            $result = $producto->Modificar($cod_inventario, $nombre, $descripcion, $id_categoria, $precio_venta, $imagen, $fyh_actualizacion, $id_empaquetado, $marca, $lote, $estatus);

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
            exit; // Finalizar el script
        break;
        case 'eliminar':
            $cod_inventario = $_POST['id']; // Verifica que este ID sea correcto.
            $result = $producto->Eliminar($cod_inventario);
            
            // Prepara la respuesta
            if ($result) {
                $respuesta = [
                    'estatus' => 1,
                    'mensaje' => "Producto eliminado exitosamente."
                ];
            } else {
                $respuesta = [
                    'estatus' => 0,
                    'mensaje' => "Error al eliminar el producto o producto no encontrado."
                ];
            }
            
            // Establece el tipo de contenido de la respuesta
            header('Content-Type: application/json');
            echo json_encode($respuesta);
            exit;
            break;
    }
    
}


include($VIEW.'inventario.php'); 
?>