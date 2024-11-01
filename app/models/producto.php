<?php
require_once(__DIR__ . '/../connectDB.php');

class Producto extends connectDB
{
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT a.cod_inventario, a.nombre, a.descripcion, di.stock, a.precio_venta, a.imagen, a.fyh_creacion, a.fyh_actualizacion, c.nombre_categoria, di.lote, di.estatus, e.cantidad, pr.marca  FROM inventario a INNER JOIN categoria c ON a.id_categoria=c.id_categoria INNER JOIN detalle_inventario di ON di.id_detalle_inventario=a.id_detalle_inventario INNER JOIN empaquetado e ON e.id_empaquetado=di.id_empaquetado INNER JOIN presentacion pr ON pr.id_presentacion=di.id_presentacion;");
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
        $resultado = $this->conex->prepare("SELECT cod_inventario,  nombre, descripcion, id_categoria, precio_venta, imagen FROM inventario WHERE id_producto = '$id'");
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

    public function Modificar($id_producto, $codigo, $nombre, $descripcion, $id_categoria, $stock_minimo, $stock_maximo, $precio_venta, $imagen)
    { 

        $sql = "UPDATE inventario SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion, id_categoria = :id_categoria, stock_minimo = :stock_minimo, stock_maximo = :stock_maximo, precio_venta = :precio_venta,imagen = :imagen 
                WHERE id_producto = :id_producto";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'codigo' => $codigo,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'id_categoria' => $id_categoria,
                'stock_minimo' => $stock_minimo,
                'stock_maximo' => $stock_maximo,
                'precio_venta' => $precio_venta,
                'imagen' => $imagen,
                'id_producto' => $id_producto
            ]);
            
        } catch (Exception $e) {
            echo "Error al modificar el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_producto)
    {
        $sql = "DELETE FROM inventario WHERE id_producto = :id_producto";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_producto' => $id_producto]);
        } catch (Exception $e) {
            echo "Error al eliminar el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
}
?>
