<?php
require_once(__DIR__ . '/../connectDB.php');

class Producto extends connectDB
{
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT a.cod_inventario, a.nombre, a.descripcion, a.fyh_actualizacion, c.nombre_categoria FROM inventario a INNER JOIN categoria c ON a.id_categoria = c.id_categoria ORDER BY a.fyh_actualizacion DESC;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function ListarInventarios()
    {
        $resultado = $this->conex->prepare("SELECT cod_inventario, nombre FROM inventario ORDER BY nombre ASC");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function ListarPresentacionesPorInventario($cod_inventario)
    {
        $resultado = $this->conex->prepare("SELECT di.id_detalle_inventario, e.cantidad as id_presentacion, di.stock, di.precio_venta FROM detalle_inventario di INNER JOIN empaquetado e ON di.id_empaquetado=e.id_empaquetado WHERE cod_inventario =  :cod_inventario");
        $resultado->bindParam(":cod_inventario", $cod_inventario, PDO::PARAM_INT);
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    
    public function Crear($nombre, $descripcion, $id_categoria, $id_marca, $imagen, $fyh_creacion, $fyh_actualizacion, $detalles)
    {
        // Iniciar la transacción
        $this->conex->beginTransaction();
    
        try {
            // Insertar en la tabla `inventario`
            $sql_inventario = "INSERT INTO inventario (nombre, descripcion, id_categoria, imagen, fyh_creacion, fyh_actualizacion) 
                    VALUES (:nombre, :descripcion, :id_categoria, :imagen, :fyh_creacion, :fyh_actualizacion)";
            
            // Preparar y ejecutar el primer INSERT para `inventario`
            $resultado_inventario = $this->conex->prepare($sql_inventario);
            $resultado_inventario->execute([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'id_categoria' => $id_categoria,
                'imagen' => $imagen,
                'fyh_creacion' => $fyh_creacion,
                'fyh_actualizacion' => $fyh_actualizacion                
            ]);
    
            // Obtener el ID del inventario insertado
            $cod_inventario = $this->conex->lastInsertId();
    
            // Insertar en `detalle_inventario` para cada detalle
            $sql_detalle = "INSERT INTO detalle_inventario (cod_inventario, stock, id_empaquetado, id_presentacion, lote, precio_venta, estatus) 
                            VALUES (:id_inventario, :stock, :id_empaquetado, :id_presentacion, :lote, :precio_venta, :estatus)";
            
            $resultado_detalle = $this->conex->prepare($sql_detalle);
    
            // Recorrer cada detalle y ejecutarlo
            foreach ($detalles as $detalle) {
                $resultado_detalle->execute([
                    'id_inventario' => $cod_inventario,
                    'stock' => $detalle['stock'],
                    'id_empaquetado' => $detalle['empaquetado'],
                    'id_presentacion' => $id_marca,
                    'lote' => $detalle['lote'],
                    'precio_venta' => $detalle['precio'],
                    'estatus' => $detalle['estatus']
                ]);
            }
    
            // Confirmar transacción
            $this->conex->commit();
            return true;
        } catch (Exception $e) {
            // Si hay un error, revertir transacción
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

    public function Modificar($cod_inventario, $nombre, $descripcion, $id_categoria, $id_marca, $imagen, $fecha_creacion, $fyh_actualizacion,$detalles) {
        try {
            // Iniciar la transacción para asegurar que todo se actualiza correctamente
            $this->conex->beginTransaction();

            // Primero, actualizar los datos principales del producto
            $sql = "UPDATE inventario SET 
                        nombre = :nombre, 
                        descripcion = :descripcion, 
                        id_categoria = :id_categoria, 
                        id_marca = :id_marca, 
                        imagen = :imagen, 
                        fyh_creacion = :fyh_creacion, 
                        fyh_actualizacion = :fyh_actualizacion
                    WHERE cod_inventario = :cod_inventario";
            
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
            $stmt->bindParam(':id_marca', $id_marca, PDO::PARAM_INT);
            $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
            $stmt->bindParam(':fyh_creacion', $fecha_creacion, PDO::PARAM_STR);
            $stmt->bindParam(':fyh_actualizacion', $fyh_actualizacion, PDO::PARAM_STR);
            $stmt->bindParam(':cod_inventario', $cod_inventario, PDO::PARAM_INT);
            $stmt->execute();

            // Ahora, actualizar los detalles del inventario
            foreach ($detalles as $detalle) {
                // Aquí necesitarás los datos de los detalles de inventario como stock, lote, precio, estatus, etc.
                // Suponiendo que tienes un campo para actualizar el stock y demás, puedes hacerlo como sigue:

                $sqlDetalle = "UPDATE detalle_inventario SET
                                    stock = :stock,
                                    lote = :lote,
                                    precio_venta = :precio_venta,
                                    estatus = :estatus
                                WHERE cod_inventario = :cod_inventario AND id_empaquetado = :id_empaquetado";

                $stmtDetalle = $this->conex->prepare($sqlDetalle);
                $stmtDetalle->bindParam(':stock', $detalle['stock'], PDO::PARAM_INT);
                $stmtDetalle->bindParam(':lote', $detalle['lote'], PDO::PARAM_STR);
                $stmtDetalle->bindParam(':precio_venta', $detalle['precio_venta'], PDO::PARAM_STR);
                $stmtDetalle->bindParam(':estatus', $detalle['estatus'], PDO::PARAM_STR);
                $stmtDetalle->bindParam(':cod_inventario', $cod_inventario, PDO::PARAM_INT);
                $stmtDetalle->bindParam(':id_empaquetado', $detalle['id_empaquetado'], PDO::PARAM_INT);
                $stmtDetalle->execute();
            }

            // Si todo salió bien, hacemos commit de la transacción
            $this->conex->commit();
            return true;

        } catch (Exception $e) {
            // Si algo sale mal, hacemos rollback
            $this->conex->rollBack();
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
    
    public function ObtenerProductoPorId($id) {
        $sql = "SELECT nombre, descripcion, id_categoria, imagen, fyh_creacion
                FROM inventario
                WHERE cod_inventario = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para obtener los detalles del inventario del producto
    public function ObtenerDetallesInventario($id) {
        $sql = "SELECT di.stock, di.lote, di.precio_venta, di.estatus, e.cantidad AS empaquetado, p.marca AS presentacion
                FROM detalle_inventario di
                JOIN empaquetado e ON di.id_empaquetado = e.id_empaquetado
                JOIN presentacion p ON di.id_presentacion = p.id_presentacion
                WHERE di.cod_inventario = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>
