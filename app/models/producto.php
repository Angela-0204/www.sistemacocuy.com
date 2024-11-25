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

    public function ListarDesgloce($fecha)
    {
        $resultado = $this->conex->prepare("SELECT i.nombre AS producto_nombre, i.descripcion AS producto_descripcion, c.nombre_categoria AS categoria, p.marca AS marca, um.medida AS unidad_medida, e.cantidad AS cantidad_empaquetado, di.precio_venta AS precio, di.stock AS stock FROM detalle_inventario di JOIN inventario i ON di.cod_inventario = i.cod_inventario JOIN categoria c ON i.id_categoria = c.id_categoria JOIN presentacion p ON i.id_presentacion = p.id_presentacion JOIN unidad_medida um ON di.cod_unidad = um.cod_unidad JOIN empaquetado e ON di.id_empaquetado = e.id_empaquetado WHERE i.fyh_creacion= :fecha;");
        $respuestaArreglo = [];
        try {
            $resultado->execute(['fecha' => $fecha]);
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
        $resultado = $this->conex->prepare("SELECT di.id_detalle_inventario, e.cantidad as id_presentacion, di.stock, di.precio_venta FROM detalle_inventario di INNER JOIN empaquetado e ON di.id_empaquetado=e.id_empaquetado WHERE di.estatus= 'activo' AND cod_inventario =  :cod_inventario");
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

    
    public function Crear($nombre, $descripcion, $id_categoria, $id_presentacion, $imagen, $fyh_creacion, $fyh_actualizacion, $detalles)
    {
        // Iniciar la transacción
        $this->conex->beginTransaction();
    
        try {
            // Insertar en la tabla `inventario`
            $sql_inventario = "INSERT INTO inventario (nombre, descripcion, id_categoria, imagen, fyh_creacion, id_presentacion, fyh_actualizacion) 
                    VALUES (:nombre, :descripcion, :id_categoria, :imagen, :fyh_creacion, :id_presentacion, :fyh_actualizacion)";
            
            // Preparar y ejecutar el primer INSERT para `inventario`
            $resultado_inventario = $this->conex->prepare($sql_inventario);
            $resultado_inventario->execute([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'id_categoria' => $id_categoria,
                'imagen' => $imagen,
                'fyh_creacion' => $fyh_creacion,
                'id_presentacion' => $id_presentacion,
                'fyh_actualizacion' => $fyh_actualizacion                
            ]);
    
            // Obtener el ID del inventario insertado
            $cod_inventario = $this->conex->lastInsertId();
    
            // Insertar en `detalle_inventario` para cada detalle
            $sql_detalle = "INSERT INTO detalle_inventario (cod_inventario, stock, id_empaquetado,lote, precio_venta, estatus, cod_unidad) 
                            VALUES (:id_inventario, :stock, :id_empaquetado, :lote, :precio_venta, :estatus, :cod_unidad)";
            
            $resultado_detalle = $this->conex->prepare($sql_detalle);
    
            // Recorrer cada detalle y ejecutarlo
            foreach ($detalles as $detalle) {
                $resultado_detalle->execute([
                    'id_inventario' => $cod_inventario,
                    'stock' => $detalle['stock'],
                    'id_empaquetado' => $detalle['empaquetado'],
                    'lote' => $detalle['lote'],
                    'cod_unidad' => $detalle['cod_unidad'],
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

    public function Modificar($cod_inventario, $nombre, $descripcion, $id_categoria, $fyh_actualizacion) {
        try {
            // Iniciar la transacción para asegurar que todo se actualiza correctamente
            $this->conex->beginTransaction();
    
            // Primero, actualizar los datos principales del producto
            $sql = "UPDATE inventario SET 
                        nombre = :nombre, 
                        descripcion = :descripcion, 
                        id_categoria = :id_categoria, 
                        fyh_actualizacion = :fyh_actualizacion
                    WHERE cod_inventario = :cod_inventario";
    
            $stmt = $this->conex->prepare($sql);
            $stmt->execute([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'id_categoria' => $id_categoria,
                'fyh_actualizacion' => $fyh_actualizacion,                
                'cod_inventario' => $cod_inventario                
            ]);
            $this->conex->commit();
            return true;
    
        } catch (Exception $e) {
            $this->conex->rollBack();
            // Log error para depuración
            error_log("Error al modificar: " . $e->getMessage());
            return false;
        }
    }
    
    
    

    public function Eliminar($cod_inventario) 
    {
        // Iniciar la transacción
        $this->conex->beginTransaction();
        
        try {
            // 1. Obtener todos los `id_detalle_inventario` asociados al `cod_inventario`
            $sql_get_detalles = "SELECT id_detalle_inventario FROM detalle_inventario WHERE cod_inventario = :cod_inventario";
            $stmt_get_detalles = $this->conex->prepare($sql_get_detalles);
            $stmt_get_detalles->execute(['cod_inventario' => $cod_inventario]);
            $detalles = $stmt_get_detalles->fetchAll(PDO::FETCH_COLUMN); // Arreglo de `id_detalle_inventario`
    
            // 2. Verificar si alguno de estos `id_detalle_inventario` existe en `detalle_pedido`
            if (!empty($detalles)) {
                $placeholders = implode(',', array_fill(0, count($detalles), '?'));
                $sql_check_pedidos = "SELECT COUNT(*) FROM detalle_pedido WHERE id_detalle_inventario IN ($placeholders)";
                $stmt_check_pedidos = $this->conex->prepare($sql_check_pedidos);
                $stmt_check_pedidos->execute($detalles);
    
                $cantidad_pedidos = $stmt_check_pedidos->fetchColumn();
                
                if ($cantidad_pedidos > 0) {
                    // Si algún detalle está en un pedido, abortar el proceso y devolver un mensaje
                    $respuesta = [
                        'estatus' => 0,
                        'mensaje' => "No se puede eliminar el inventario ya que uno de sus detalles está asociado a un pedido existente."
                    ];
                    // Establecer el tipo de contenido de la respuesta
                    header('Content-Type: application/json');
                    echo json_encode($respuesta); // Devolver la respuesta como JSON
                    exit;
                }
            }
    
            // 3. Eliminar los registros en `detalle_inventario` para este `cod_inventario`
            $sql_delete_detalle_inventario = "DELETE FROM detalle_inventario WHERE cod_inventario = :cod_inventario";
            $stmt_delete_detalle_inventario = $this->conex->prepare($sql_delete_detalle_inventario);
            $stmt_delete_detalle_inventario->execute(['cod_inventario' => $cod_inventario]);
    
            // 4. Eliminar el registro en `inventario`
            $sql_delete_inventario = "DELETE FROM inventario WHERE cod_inventario = :cod_inventario";
            $stmt_delete_inventario = $this->conex->prepare($sql_delete_inventario);
            $stmt_delete_inventario->execute(['cod_inventario' => $cod_inventario]);
    
            // Confirmar la transacción
            $this->conex->commit();
            return true;
    
        } catch (Exception $e) {
            // Si ocurre algún error, revertir los cambios y devolver el mensaje de error en formato JSON
            $this->conex->rollback();
            $respuesta = [
                'estatus' => 0,
                'mensaje' => "Error al eliminar el producto: " . $e->getMessage() // Aquí se captura el mensaje de la excepción
            ];
            // Establecer el tipo de contenido de la respuesta
            header('Content-Type: application/json');
            echo json_encode($respuesta); // Devolver la respuesta como JSON
            exit;
        }
    }
    public function ObtenerProductoPorId($id) {
        $sql = "SELECT nombre, descripcion, id_categoria, imagen, fyh_actualizacion as fyh_creacion
                FROM inventario
                WHERE cod_inventario = :id";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para obtener los detalles del inventario del producto
    public function ObtenerDetallesInventario($id) {
        $sql = "SELECT u.cod_unidad, e.id_empaquetado, di.id_detalle_inventario, di.stock, di.lote, di.precio_venta, di.estatus, di.cod_unidad, e.cantidad AS empaquetado, u.medida FROM detalle_inventario di JOIN empaquetado e ON di.id_empaquetado = e.id_empaquetado JOIN unidad_medida u ON di.cod_unidad = u.cod_unidad WHERE di.cod_inventario =:id AND di.estatus='activo';";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  

    public function EliminarDetalle($id_detalle_inventario) {
        try {
            $sql = "DELETE FROM detalle_inventario WHERE id_detalle_inventario = :id_detalle_inventario";
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':id_detalle_inventario', $id_detalle_inventario, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log("Error al eliminar detalle: " . $e->getMessage());
            return false;
        }
    }//modificar
    public function GuardarDetalle($id_detalle_inventario, $stock, $lote, $precio, $estatus) {
        try {
            $sql = "UPDATE detalle_inventario SET 
                        stock = :stock, 
                        lote = :lote, 
                        precio_venta = :precio_venta, 
                        estatus = :estatus
                    WHERE id_detalle_inventario = :id_detalle_inventario";
            
            $stmt = $this->conex->prepare($sql);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':lote', $lote, PDO::PARAM_STR);
            $stmt->bindParam(':precio_venta', $precio, PDO::PARAM_STR);
            $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);
            $stmt->bindParam(':id_detalle_inventario', $id_detalle_inventario, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log("Error al guardar detalle: " . $e->getMessage());
            return false;
        }
    }

    public function NuevoDetalle($id_cod, $id_empaquetado, $stock, $lote, $precio_venta, $cod_unidad, $estatus) {
        try {
            // Verificar si ya existe un detalle con el mismo cod_inventario y id_empaquetado
            $sqlCheck = "SELECT COUNT(*) FROM detalle_inventario WHERE cod_inventario = :cod_inventario AND id_empaquetado = :id_empaquetado  AND cod_unidad = :cod_unidad";
            $stmtCheck = $this->conex->prepare($sqlCheck);
            $stmtCheck->bindParam(':cod_inventario', $id_cod, PDO::PARAM_INT);
            $stmtCheck->bindParam(':id_empaquetado', $id_empaquetado, PDO::PARAM_INT);
            $stmtCheck->bindParam(':cod_unidad', $cod_unidad, PDO::PARAM_INT);
            $stmtCheck->execute();
    
            // Obtener el resultado de la consulta
            $count = $stmtCheck->fetchColumn();
    
            // Si el resultado es mayor que 0, significa que ya existe el detalle
            if ($count > 0) {
                // Si ya existe, devolver false o un mensaje de error
                return [
                    'estatus' => 0,
                    'mensaje' => 'Ya existe un detalle con el mismo empaquetado para este inventario.'
                ];
            }
    
            // Si no existe el detalle, procedemos con la inserción
            $sqlInsert = "INSERT INTO detalle_inventario (cod_inventario, stock, lote, precio_venta, id_empaquetado, cod_unidad, estatus ) 
                          VALUES (:cod_inventario, :stock, :lote, :precio_venta, :id_empaquetado, :cod_unidad, :estatus)";
    
            // Preparar la sentencia de inserción
            $stmt = $this->conex->prepare($sqlInsert);
    
            // Enlazar los parámetros con los valores recibidos
            $stmt->bindParam(':cod_inventario', $id_cod, PDO::PARAM_INT);  
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':lote', $lote, PDO::PARAM_STR);            
            $stmt->bindParam(':precio_venta', $precio_venta, PDO::PARAM_STR);
            $stmt->bindParam(':id_empaquetado', $id_empaquetado, PDO::PARAM_INT);
            $stmt->bindParam(':cod_unidad', $cod_unidad, PDO::PARAM_INT);
            $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);
          
    
            // Ejecutar la sentencia
            $stmt->execute();
    
            // Si todo es exitoso, devolver true
            return [
                'estatus' => 1,
                'mensaje' => 'Detalle de inventario creado exitosamente.'
            ];
    
        } catch (Exception $e) {
            // Si hay un error, lo registramos en el log y devolvemos false
            error_log("Error al guardar detalle de inventario: " . $e->getMessage());
            return [
                'estatus' => 0,
                'mensaje' => 'Hubo un error al guardar el detalle de inventario.'
            ];
        }
    }
    
    
    
    
}
?>
