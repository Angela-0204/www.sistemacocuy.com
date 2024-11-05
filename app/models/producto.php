<?php
require_once(__DIR__ . '/../connectDB.php');

class Producto extends connectDB
{
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT a.cod_inventario, a.nombre, a.descripcion, di.stock, a.precio_venta, a.imagen, a.fyh_creacion, a.fyh_actualizacion, c.nombre_categoria, di.lote, di.estatus, e.cantidad, pr.marca  FROM inventario a INNER JOIN categoria c ON a.id_categoria=c.id_categoria INNER JOIN detalle_inventario di ON di.id_detalle_inventario=a.id_detalle_inventario INNER JOIN empaquetado e ON e.id_empaquetado=di.id_empaquetado INNER JOIN presentacion pr ON pr.id_presentacion=di.id_presentacion ORDER BY a.fyh_actualizacion desc;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function ListarEnPedido()
    {
        $resultado = $this->conex->prepare("SELECT di.id_detalle_inventario as cod_inventario, a.nombre, a.descripcion, di.stock, a.precio_venta, a.imagen, a.fyh_creacion, a.fyh_actualizacion, c.nombre_categoria, di.lote, di.estatus, e.cantidad, pr.marca FROM inventario a INNER JOIN categoria c ON a.id_categoria=c.id_categoria INNER JOIN detalle_inventario di ON di.id_detalle_inventario=a.id_detalle_inventario INNER JOIN empaquetado e ON e.id_empaquetado=di.id_empaquetado INNER JOIN presentacion pr ON pr.id_presentacion=di.id_presentacion ORDER BY a.fyh_actualizacion desc;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($nombre, $descripcion, $id_categoria, $stock, $precio_venta, $imagen, $fyh_creacion, $fyh_actualizacion, $id_empaquetado, $id_presentacion, $lote, $estatus)
    {
        // Iniciamos la transacción
        $this->conex->beginTransaction();
        
        try {
            // SQL para insertar en la tabla detalle_inventario
            $sql_inventario = "INSERT INTO detalle_inventario (stock, id_empaquetado, id_presentacion, lote, estatus) 
                    VALUES (:stock, :id_empaquetado, :id_presentacion, :lote, :estatus)";
            // Preparamos la consulta
            $resultado_inventario = $this->conex->prepare($sql_inventario);
            
            // Ejecutamos el primer INSERT en inventario
            $resultado_inventario->execute([
                'stock' => $stock,
                'id_empaquetado' => $id_empaquetado,
                'id_presentacion' => $id_presentacion,
                'lote' => $lote,
                'estatus' => $estatus
            ]);
    
            // Obtener el ID generado del último registro insertado en inventario
            $cod_inventario = $this->conex->lastInsertId();
            
            // SQL para insertar en la tabla inventario
            $sql_detalle_inventario = "INSERT INTO inventario (id_detalle_inventario, nombre, descripcion, id_categoria, precio_venta, imagen, fyh_creacion, fyh_actualizacion) 
                    VALUES (:id_detalle_inventario, :nombre, :descripcion, :id_categoria, :precio_venta, :imagen, :fyh_creacion, :fyh_actualizacion)";
            
            // Preparamos la consulta para inventario
            $resultado_detalle = $this->conex->prepare($sql_detalle_inventario);
            
            // Ejecutamos el segundo INSERT en inventario con el cod_inventario obtenido
            $resultado_detalle->execute([
                'id_detalle_inventario' => $cod_inventario,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'id_categoria' => $id_categoria,
                'precio_venta' => $precio_venta,
                'imagen' => $imagen,
                'fyh_creacion' => $fyh_creacion,
                'fyh_actualizacion' => $fyh_actualizacion                
            ]);
    
            // Si todo se ejecutó correctamente, hacemos el commit
            $this->conex->commit();
            return true;
        } catch (Exception $e) {
            // Si ocurre un error, hacemos rollback
            $this->conex->rollback();
            echo "Error al crear el producto: " . $e->getMessage();
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

    public function Modificar($cod_inventario, $nombre, $descripcion, $id_categoria, $precio_venta, $imagen, $fyh_actualizacion, $id_empaquetado, $id_presentacion, $lote, $estatus)
    {
        // Iniciamos la transacción
        $this->conex->beginTransaction();
    
        try {
            // Primero, obtenemos el `id_detalle_inventario` de la tabla `inventario` para este producto
            $sql_get_detalle_id = "SELECT id_detalle_inventario FROM inventario WHERE cod_inventario = :cod_inventario";
            $stmt = $this->conex->prepare($sql_get_detalle_id);
            $stmt->execute(['cod_inventario' => $cod_inventario]);
            $result = $stmt->fetch();
    
            if (!$result) {
                throw new Exception("No se encontró el producto con el código: " . $cod_inventario);
            }
    
            $id_detalle_inventario = $result['id_detalle_inventario'];
    
            // Luego, actualizamos la tabla `detalle_inventario` usando el `id_detalle_inventario` obtenido
            $sql_detalle_inventario = "UPDATE detalle_inventario 
                                        SET id_empaquetado = :id_empaquetado, 
                                            id_presentacion = :id_presentacion, 
                                            lote = :lote, 
                                            estatus = :estatus
                                        WHERE id_detalle_inventario = :id_detalle_inventario";
            
            $resultado_detalle = $this->conex->prepare($sql_detalle_inventario);
    
            // Ejecutamos la consulta para `detalle_inventario`
            $resultado_detalle->execute([
                'id_empaquetado' => $id_empaquetado,
                'id_presentacion' => $id_presentacion,
                'lote' => $lote,
                'estatus' => $estatus,
                'id_detalle_inventario' => $id_detalle_inventario
            ]);
    
            // Luego, actualizamos la tabla `inventario`
            $sql_inventario = "UPDATE inventario 
                               SET nombre = :nombre, 
                                   descripcion = :descripcion, 
                                   id_categoria = :id_categoria, 
                                   precio_venta = :precio_venta, 
                                   imagen = :imagen, 
                                   fyh_actualizacion = :fyh_actualizacion
                               WHERE cod_inventario = :cod_inventario";
            
            $resultado_inventario = $this->conex->prepare($sql_inventario);
    
            // Ejecutamos la consulta para `inventario`
            $resultado_inventario->execute([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'id_categoria' => $id_categoria,
                'precio_venta' => $precio_venta,
                'imagen' => $imagen,
                'fyh_actualizacion' => $fyh_actualizacion,
                'cod_inventario' => $cod_inventario
            ]);
    
            // Hacemos el commit de la transacción si todo salió bien
            $this->conex->commit();
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, hacemos rollback
            $this->conex->rollback();
            echo "Error al modificar el producto: " . $e->getMessage();
            return false;
        }
    }
    

    public function Eliminar($cod_inventario) 
    {
        // Iniciamos la transacción
        $this->conex->beginTransaction();
    
        try {
            // Primero, obtenemos el `id_detalle_inventario` de la tabla `inventario` para este producto
            $sql_get_detalle_id = "SELECT id_detalle_inventario FROM inventario WHERE cod_inventario = :cod_inventario";
            $stmt = $this->conex->prepare($sql_get_detalle_id);
            $stmt->execute(['cod_inventario' => $cod_inventario]);
            $result = $stmt->fetch();
    
            if (!$result) {
                throw new Exception("No se encontró el producto con el código: " . $cod_inventario);
            }
    
            $id_detalle_inventario = $result['id_detalle_inventario'];
    
            // Eliminamos primero el registro de `inventario`
            $sql_delete_inventario = "DELETE FROM inventario WHERE cod_inventario = :cod_inventario";
            $stmt_delete_inventario = $this->conex->prepare($sql_delete_inventario);
            $stmt_delete_inventario->execute(['cod_inventario' => $cod_inventario]);
    
            // Luego eliminamos el registro correspondiente en `detalle_inventario`
            $sql_delete_detalle_inventario = "DELETE FROM detalle_inventario WHERE id_detalle_inventario = :id_detalle_inventario";
            $stmt_delete_detalle_inventario = $this->conex->prepare($sql_delete_detalle_inventario);
            $stmt_delete_detalle_inventario->execute(['id_detalle_inventario' => $id_detalle_inventario]);
    
            // Si todo sale bien, hacemos el commit de la transacción
            $this->conex->commit();
            return true;
    
        } catch (Exception $e) {
            // Si ocurre algún error, hacemos rollback
            $this->conex->rollback();
            echo "Error al eliminar el producto: " . $e->getMessage();
            return false;
        }
    }
    
    
    
    
}
?>
