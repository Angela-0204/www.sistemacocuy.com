<?php
include('app/config.php');
include($MODELS . 'producto.php');
include($MODELS . 'categoria.php');
include($MODELS . 'caja.php');
$producto = new Producto();
$categoria = new Categoria();
$caja = new Caja();
//Para listar los productos
$data_products = $producto->Listar();
session_start();

//Para listar categorias en los selects
$data_categorias = $categoria->Listar();
$data_cajas = $caja->Listar();
//Para modificar un registro
if(isset($_POST['accion'])){
    switch($_POST['accion']){
        case 'modificar':
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
            $script = "<script type='text/javascript'>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rol',
                        text: '".$respuesta['mensaje'] ."'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '?pagina=inventario';
                        }
                    });
                });
                </script>";
        break;
    }
}
//Para eliminar registro
if(isset($_GET['accion'])){
    switch($_GET['accion']){
    case 'eliminar':
        $result = $producto->Eliminar($_GET['id']);
        $respuesta = array();
        if ($result) {
            $respuesta['estatus'] = 1;
            $respuesta['mensaje'] = "Producto Eliminado exitosamente.";
        } else {
            $respuesta['estatus'] = 0;
            $respuesta['mensaje'] = "Error al eliminar el producto.";
        }
        $script = "<script type='text/javascript'>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Rol',
                text: '".$respuesta['mensaje'] ."'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?pagina=inventario';
                }
            });
        });
        </script>";
        break;
        case 'consultar':
            $data = $producto->Buscar($_GET['id']);
            require_once($VIEW.'/producto/editar.php'); 
            return 0;
    }
}


include($VIEW.'inventario.php'); 
?>