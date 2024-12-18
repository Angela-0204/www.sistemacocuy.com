<?php
require_once(__DIR__ . '/../connectDB.php');

class Caja extends connectDB
{
    private $id_empaquetado;
    private $cantidad;
    private $descripcion;

    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM empaquetado;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($cantidad, $descripcion)
    {
        $sql = "INSERT INTO empaquetado (cantidad, descripcion) 
                VALUES (:cantidad, :descripcion)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'cantidad' => $cantidad,
                'descripcion' => $descripcion
            ]);
        } catch (Exception $e) {
            echo "Error al crear el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM empaquetado WHERE id_empaquetado = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_empaquetado, $cantidad, $descripcion)
    {
        $sql = "UPDATE empaquetado SET cantidad = :cantidad, descripcion = :descripcion 
                WHERE id_empaquetado = :id_empaquetado";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'cantidad' => $cantidad,
                'descripcion' => $descripcion,
                'id_empaquetado' => $id_empaquetado
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el empaquetado: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_empaquetado)
    {
        $sql = "DELETE FROM empaquetado WHERE id_empaquetado = :id_empaquetado";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_empaquetado' => $id_empaquetado]);
        } catch (Exception $e) {
            echo "Error al eliminar el empaquetado: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

}
?>
