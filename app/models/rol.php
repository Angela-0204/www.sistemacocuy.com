<?php
require_once(__DIR__ . '/../connectDB.php');

class Rol extends connectDB
{
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT * FROM tb_roles");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($nombre_rol)
    {
        $resultado = $this->conex->prepare("INSERT INTO tb_roles (nombre_rol) VALUES (:nombre_rol)");
        try {
            $resultado->execute(['nombre_rol' => $nombre_rol]);
        } catch (Exception $e) {
            echo "Error al crear el rol: " . $e->getMessage();
            return false;
        }
        return true;
    }
}
?>
