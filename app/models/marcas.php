<?php
require_once(__DIR__ . '/../connectDB.php');

class Marcas extends connectDB
{
    private $id_presentacion;
    private $marca;
    private $cod_unidad;
    private $medida;
    
  

    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT c.cod_unidad, a.id_presentacion, c.medida, a.marca FROM presentacion a INNER JOIN unidad_medida c ON a.cod_unidad=c.cod_unidad;");

        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($marca, $cod_unidad)
    {
        $sql = "INSERT INTO presentacion (marca, cod_unidad) 
                VALUES (:marca, :cod_unidad)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'marca' => $marca,
                'cod_unidad' => $cod_unidad
                
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

    public function Modificar($id_presentacion, $marca, $cod_unidad)
    {
        $sql = "UPDATE presentacion SET marca = :marca, cod_unidad = :cod_unidad
                WHERE id_presentacion = :id_presentacion";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'marca' => $marca,
                'cod_unidad' => $cod_unidad,
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
