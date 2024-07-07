<?php
require_once(__DIR__ . '/../connectDB.php');

class Categoria extends connectDB
{
    private $id_categoria;
    private $nombre_categoria;
    private $fyh_creacion;
    private $fyh_actualizacion;

    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM tb_categorias;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($nombre_categoria, $fyh_creacion, $fyh_actualizacion)
    {
        $sql = "INSERT INTO tb_categorias (nombre_categoria, fyh_creacion, fyh_actualizacion) 
                VALUES (:nombre_categoria, :fyh_creacion, :fyh_actualizacion)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'nombre_categoria' => $nombre_categoria,
                'fyh_creacion' => $fyh_creacion,
                'fyh_actualizacion' => $fyh_actualizacion
            ]);
        } catch (Exception $e) {
            echo "Error al crear el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM tb_categorias WHERE id_categoria = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_categoria, $nombre_categoria, $fyh_actualizacion)
    {
        $sql = "UPDATE tb_categorias SET nombre_categoria = :nombre_categoria, fyh_actualizacion = :fyh_actualizacion 
                WHERE id_categoria = :id_categoria";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'nombre_categoria' => $nombre_categoria,
                'fyh_actualizacion' => $fyh_actualizacion,
                'id_categoria' => $id_categoria
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_categoria)
    {
        $sql = "DELETE FROM tb_categorias WHERE id_categoria = :id_categoria";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_categoria' => $id_categoria]);
        } catch (Exception $e) {
            echo "Error al eliminar la categoria: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

}
?>
