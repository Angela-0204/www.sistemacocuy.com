<?php
require_once(__DIR__ . '/../connectDB.php');

class Categoria extends connectDB
{
    private $id_categoria;
    private $nombre_categoria;


    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM categoria;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($nombre_categoria)
    {
        $sql = "INSERT INTO categoria (nombre_categoria) 
                VALUES (:nombre_categoria)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'nombre_categoria' => $nombre_categoria,
         
            ]);
        } catch (Exception $e) {
            echo "Error al crear el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM categoria WHERE id_categoria = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_categoria, $nombre_categoria)
    {
        $sql = "UPDATE categoria SET nombre_categoria = :nombre_categoria
                WHERE id_categoria = :id_categoria";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'nombre_categoria' => $nombre_categoria,
                
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
        $sql = "DELETE FROM categoria WHERE id_categoria = :id_categoria";
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
