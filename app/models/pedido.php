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
                'estatus' => 1, // El valor de "estatus" aquí podría referirse a "activo" o "pendiente" 
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
    
    public function ConsultarPedido($id_pedido) {
        try {
            // Consulta de la información básica del pedido
            $sql = "SELECT 
                        p.id_pedido, 
                        p.fecha_pedido, 
                        p.estatus, 
                        c.nombre_cliente, 
                        c.cedula_rif, 
                        c.telefono, 
                        u.names as usuario
                    FROM pedido p
                    JOIN cliente c ON p.cod_cliente = c.cod_cliente
                    JOIN usuario u ON p.id_users = u.id_users
                    WHERE p.id_pedido = :id_pedido";
    
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
            $stmt->execute();
            $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$pedido) {
                throw new Exception("Pedido no encontrado.");
            }
    
            // Ahora obtenemos los detalles del pedido, con la información de los productos
            $sqlDetalles = "SELECT 
                                dp.id_detalle_pedido, 
                                dp.cantidad, 
                                di.id_empaquetado, 
                                di.stock, 
                                di.lote, 
                                di.precio_venta, 
                                di.estatus, 
                                i.nombre as producto_nombre, 
                                i.descripcion as producto_descripcion,
                                c.nombre_categoria, 
                                e.descripcion as empaquetado_descripcion,
                                um.medida as unidad_medida
                            FROM detalle_pedido dp
                            JOIN detalle_inventario di ON dp.id_detalle_inventario = di.id_detalle_inventario
                            JOIN inventario i ON di.cod_inventario = i.cod_inventario
                            JOIN categoria c ON i.id_categoria = c.id_categoria
                            JOIN empaquetado e ON di.id_empaquetado = e.id_empaquetado
                            JOIN presentacion p ON di.id_presentacion = p.id_presentacion
                            JOIN unidad_medida um ON p.cod_unidad = um.cod_unidad
                            WHERE dp.id_pedido = :id_pedido";
    
            $stmtDetalles = $this->conex->prepare($sqlDetalles);
            $stmtDetalles->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
            $stmtDetalles->execute();
            $detalles = $stmtDetalles->fetchAll(PDO::FETCH_ASSOC);
    
            // Calcular el subtotal y el total
            $total = 0;
            foreach ($detalles as &$detalle) {
                $subtotal = $detalle['precio_venta'] * $detalle['cantidad'];
                $total += $subtotal;
                $detalle['subtotal'] = $subtotal;
            }
    
            // Devolver todos los datos en un array
            $data = [
                'pedido' => $pedido,
                'detalles' => $detalles,
                'total' => $total
            ];
    
            return $data;
    
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}
?>
