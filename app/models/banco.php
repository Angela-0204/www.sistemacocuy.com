<?php
require_once(__DIR__ . '/../connectDB.php');

class Banco extends connectDB
{
    private $id_banco;
    private $nombre_banco;
    private $nombre;
    private $datos_banco;


    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT a.id_banco, b.id_tipo_pago,a.nombre_banco,b.nombre, a.datos_banco FROM banco a INNER JOIN tipo_pago b ON b.id_tipo_pago=a.id_tipo_pago;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($nombre_banco, $datos_banco,$id_tipo_pago)
    {
        $sql = "INSERT INTO banco (nombre_banco, datos_banco,id_tipo_pago) 
                VALUES (:nombre_banco, :datos_banco, :id_tipo_pago)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'nombre_banco' => $nombre_banco,
                'datos_banco' => $datos_banco,
                'id_tipo_pago' => $id_tipo_pago
         
            ]);
        } catch (Exception $e) {
            echo "Error al crear el banco: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM banco WHERE id_banco = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_banco, $nombre_banco, $datos_banco, $id_tipo_pago)
    {
        $sql = "UPDATE banco SET nombre_banco = :nombre_banco, datos_banco = :datos_banco, id_tipo_pago = :id_tipo_pago
                WHERE id_banco = :id_banco";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'nombre_banco' => $nombre_banco,
                'datos_banco' => $datos_banco,
                'id_tipo_pago' => $id_tipo_pago,
                
                'id_banco' => $id_banco
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el banco: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_banco)
    {
        $sql = "DELETE FROM banco WHERE id_banco = :id_banco";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_banco' => $id_banco]);
        } catch (Exception $e) {
            echo "Error al eliminar el Banco: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

}
?>
