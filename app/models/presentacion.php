<?php
require_once(__DIR__ . '/../connectDB.php');

class Presentacion extends connectDB
{
    private $id_presentacion;
    private $litraje;
   
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM presentacion;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function Crear($id_presentacion, $litraje)
    {
        $sql = "INSERT INTO presentacion (id_presentacion, litraje) 
                VALUES (:id_presentacion, :litraje)";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute([
                'id_presentacion' => $id_presentacion,
                'litraje' => $litraje
               
            ]);
        } catch (Exception $e) {
            echo "Error al crear el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }






}



?>