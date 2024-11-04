<?php
require_once(__DIR__ . '/../connectDB.php');

class Medida extends connectDB
{
    private $cod_unidad;
    private $medida;
  

    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM unidad_medida;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($medida)
    {
        $sql = "INSERT INTO unidad_medida (medida) 
                VALUES (:medida)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'medida' => $medida,
                
            ]);
        } catch (Exception $e) {
            echo "Error al crear la medida: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM unidad_medida WHERE cod_unidad = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($cod_unidad, $medida)
    {
        $sql = "UPDATE unidad_medida SET medida = :medida
                WHERE cod_unidad = :cod_unidad";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'medida' => $medida,
                'cod_unidad' => $cod_unidad
            ]);
        } catch (Exception $e) {
            echo "Error al modificar la medida: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function VerificarVinculacion($cod_unidad)
    {
        // Consulta para verificar la vinculación en la tabla `presentacion`
        $sql = "SELECT marca FROM presentacion WHERE cod_unidad = :cod_unidad";
        $stmt = $this->conex->prepare($sql);
        $stmt->execute(['cod_unidad' => $cod_unidad]);
    
        // Obtener el resultado
        $presentacion = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($presentacion) {
            // Si existe una vinculación, devolver el valor de `marca`
            return $presentacion['marca'];
        }
    
        // Si no hay vinculación, devolver `null` o `false`
        return false;
    }
    
    public function Eliminar($cod_unidad)
    {
        // Eliminar el registro de `unidad_medida` sin verificación previa
        $sql = "DELETE FROM unidad_medida WHERE cod_unidad = :cod_unidad";
        $resultado = $this->conex->prepare($sql);
    
        try {
            $resultado->execute(['cod_unidad' => $cod_unidad]);
        } catch (Exception $e) {
            echo "Error al eliminar la medida: " . $e->getMessage();
            return false;
        }
    
        return true;
    }
    

}
?>
