<?php
require_once(__DIR__ . '/../connectDB.php');

class Tipo extends connectDB
{
    private $id_tipo_caja;
    private $nombre;
    private $identificacion;
    private $datos;


    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM tipo_pago;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($nombre, $identificacion, $datos)
    {
        $sql = "INSERT INTO tipo_pago (nombre, identificacion, datos) 
                VALUES (:nombre, :identificacion, :datos)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'nombre' => $nombre,
                'identificacion' => $identificacion,
                'datos' => $datos
            ]);
        } catch (Exception $e) {
            echo "Error al agregar el tipo de pago: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM tipo_pago WHERE id_tipo_pago = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_tipo_pago, $nombre, $identificacion, $datos)
    {
        $sql = "UPDATE tipo_pago SET nombre = :nombre, identificacion = :identificacion, datos = :datos
                WHERE id_tipo_pago = :id_tipo_pago";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'nombre' => $nombre,
                'identificacion' => $identificacion,
                'datos' => $datos,
                'id_tipo_pago' => $id_tipo_pago
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el tipo de pago: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_tipo_pago)
    {
        $sql = "DELETE FROM tipo_pago WHERE id_tipo_pago = :id_tipo_pago";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_tipo_pago' => $id_tipo_pago]);
        } catch (Exception $e) {
            echo "Error al eliminar el pago: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

}
?>
