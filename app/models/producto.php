<?php
require_once(__DIR__ . '/../connectDB.php');

class Producto extends connectDB
{
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT p.litraje, a.id_producto, a.codigo, a.nombre, a.descripcion, a.id_categoria, a.stock, a.stock_minimo, a.stock_maximo, a.precio_venta, a.imagen, a.fyh_creacion, a.fyh_actualizacion, c.nombre_categoria FROM inventario a INNER JOIN tb_categorias c ON a.id_categoria=c.id_categoria INNER JOIN presentacion p ON p.id_presentacion=a.id_presentacion;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($codigo, $nombre, $descripcion, $id_categoria, $stock, $stock_minimo, $stock_maximo, $precio_venta, $imagen, $fyh_creacion, $fyh_actualizacion, $id_caja, $litraje)
    {
        $sql = "INSERT INTO inventario (codigo, nombre, descripcion, id_categoria, stock, stock_minimo, stock_maximo, precio_venta, imagen, fyh_creacion, fyh_actualizacion, id_caja, id_presentacion) 
                VALUES (:codigo, :nombre, :descripcion, :id_categoria, :stock, :stock_minimo, :stock_maximo, :precio_venta, :imagen, :fyh_creacion, :fyh_actualizacion, :id_caja, :litraje)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'codigo' => $codigo,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'id_categoria' => $id_categoria,
                'stock' => $stock,
                'stock_minimo' => $stock_minimo,
                'stock_maximo' => $stock_maximo,
                'precio_venta' => $precio_venta,
                'imagen' => $imagen,
                'fyh_creacion' => $fyh_creacion,
                'fyh_actualizacion' => $fyh_actualizacion,
                'id_caja' => $id_caja,
                'litraje' => $litraje
            ]);
        } catch (Exception $e) {
            echo "Error al crear el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT id_producto, codigo, nombre, descripcion, id_categoria, stock, stock_minimo, stock_maximo, precio_venta, imagen FROM inventario WHERE id_producto = '$id'");
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
