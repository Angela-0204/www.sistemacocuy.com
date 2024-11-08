<?php
require_once(__DIR__ . '/../connectDB.php');

class Pedido extends connectDB
{
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT p.id_pedido, p.fecha_pedido, c.nombre_cliente, c.apellido, p.estatus FROM pedido p INNER JOIN cliente c ON p.cod_cliente=c.cod_cliente ORDER BY p.fecha_pedido desc;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    //Este si es funcional
    public function Crear($cod_cliente, $id_users, $fecha_pedido, $productos)
    {
        // Iniciar la transacción
        $this->conex->beginTransaction();
    
        try {
            // Insertar el pedido en la tabla `pedido`
            $sql_pedido = "INSERT INTO pedido (fecha_pedido, estatus, cod_cliente, id_users) 
                           VALUES (:fecha_pedido, :estatus, :cod_cliente, :id_users)";
            $stmt_pedido = $this->conex->prepare($sql_pedido);
            $stmt_pedido->execute([
                'fecha_pedido' => $fecha_pedido,
                'estatus' => 1,
                'cod_cliente' => $cod_cliente,
                'id_users' => $id_users
            ]);
    
            // Obtener el ID del último pedido insertado
            $id_pedido = $this->conex->lastInsertId();
    
            // Preparar el SQL para insertar en `detalle_pedido`
            $sql_detalle = "INSERT INTO detalle_pedido (cantidad, id_detalle_inventario, id_pedido) 
                            VALUES (:cantidad, :id_detalle_inventario, :id_pedido)";
            $stmt_detalle = $this->conex->prepare($sql_detalle);
    
            // Preparar el SQL para actualizar el stock en `detalle_inventario`
            $sql_actualizar_stock = "UPDATE detalle_inventario 
                                     SET stock = stock - :cantidad 
                                     WHERE id_detalle_inventario = :id_detalle_inventario";
            $stmt_actualizar_stock = $this->conex->prepare($sql_actualizar_stock);
    
            // Recorrer los productos y agregar cada uno al detalle del pedido
            foreach ($productos as $producto) {
                // Insertar cada producto en `detalle_pedido`
                $stmt_detalle->execute([
                    'cantidad' => $producto['cantidad'],
                    'id_detalle_inventario' => $producto['id_detalle_inventario'],
                    'id_pedido' => $id_pedido
                ]);
    
                // Actualizar el stock en `detalle_inventario`
                $stmt_actualizar_stock->execute([
                    'cantidad' => $producto['cantidad'],
                    'id_detalle_inventario' => $producto['id_detalle_inventario']
                ]);
            }
    
            // Confirmar la transacción
            $this->conex->commit();
            return true;
    
        } catch (Exception $e) {
            // Revertir cambios en caso de error
            $this->conex->rollback();
            echo "Error al registrar el pedido: " . $e->getMessage();
            return false;
        }
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT a.cod_inventario, a.nombre, pr.id_presentacion as id_marca,a.descripcion, c.id_categoria as id_categoria , e.id_empaquetado as id_empaquetado, di.stock, a.precio_venta, di.lote, di.estatus, a.imagen, a.fyh_actualizacion FROM inventario a INNER JOIN categoria c ON a.id_categoria=c.id_categoria INNER JOIN detalle_inventario di ON di.id_detalle_inventario=a.id_detalle_inventario INNER JOIN empaquetado e ON e.id_empaquetado=di.id_empaquetado INNER JOIN presentacion pr ON pr.id_presentacion=di.id_presentacion WHERE a.cod_inventario='$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function BuscarPorCategoria($id_categoria)
    {
        $resultado = $this->conex->prepare("SELECT a.id_producto, a.codigo, a.nombre, a.descripcion, a.id_categoria, a.stock, a.stock_minimo, a.stock_maximo, a.precio_venta,  a.imagen, a.fyh_creacion, a.fyh_actualizacion, c.nombre_categoria FROM inventario a INNER JOIN tb_categorias c ON a.id_categoria=c.id_categoria WHERE c.id_categoria=$id_categoria;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    } 
    
    
}
?>
