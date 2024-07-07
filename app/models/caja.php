<?php
require_once(__DIR__ . '/../connectDB.php');

class Caja extends connectDB
{
    private $id_caja;
    private $cantidad;
    private $descripcion;

    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM caja;");
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
        $sql = "INSERT INTO caja (cantidad, descripcion) 
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
        $resultado = $this->conex->prepare("SELECT * FROM caja WHERE id_caja = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_caja, $cantidad, $descripcion)
    {
        $sql = "UPDATE caja SET cantidad = :cantidad, descripcion = :descripcion 
                WHERE id_caja = :id_caja";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'cantidad' => $cantidad,
                'descripcion' => $descripcion,
                'id_caja' => $id_caja
            ]);
        } catch (Exception $e) {
            echo "Error al modificar la caja: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_caja)
    {
        $sql = "DELETE FROM caja WHERE id_caja = :id_caja";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_caja' => $id_caja]);
        } catch (Exception $e) {
            echo "Error al eliminar la caja: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

}
?>
