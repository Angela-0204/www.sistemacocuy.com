<?php
require_once(__DIR__ . '/../connectDB.php');

class Marcas extends connectDB
{
    private $id_presentacion;
    private $marca;
  
    
  

    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT  id_presentacion,  marca FROM presentacion  ");

        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($marca)
    {
        $sql = "INSERT INTO presentacion (marca) 
                VALUES (:marca)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'marca' => $marca,
              
                
            ]);
        } catch (Exception $e) {
            echo "Error al crear el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM presentacion WHERE id_presentacion = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_presentacion, $marca)
    {
        $sql = "UPDATE presentacion SET marca = :marca
                WHERE id_presentacion = :id_presentacion";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'marca' => $marca,
               
                'id_presentacion' => $id_presentacion
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_presentacion)
    {
        $sql = "DELETE FROM presentacion WHERE id_presentacion = :id_presentacion";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_presentacion' => $id_presentacion]);
        } catch (Exception $e) {
            echo "Error al eliminar la marca: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

}
?>
