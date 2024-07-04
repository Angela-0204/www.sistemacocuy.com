<?php
require_once(__DIR__ . '/../connectDB.php');

class Categoria extends connectDB
{
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM tb_categorias;");
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
