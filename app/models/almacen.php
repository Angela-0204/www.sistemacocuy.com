<?php
require_once(__DIR__ . '/../connectDB.php');

class Almacen extends connectDB
{
    private $id_almacen;
    private $nombre_almacen;
   
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM almacen;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

}
?>
