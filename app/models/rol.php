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

    public function Crear($nombre_rol, $fyh_creacion, $fyh_actualizacion)
    {
        $resultado = $this->conex->prepare("INSERT INTO tb_roles (nombre_rol, fyh_creacion, fyh_actualizacion) VALUES (:nombre_rol, :fyh_creacion, :fyh_actualizacion)");
        try {
            $resultado->execute([
                'nombre_rol' => $nombre_rol,
                'fyh_creacion' => $fyh_creacion,
                'fyh_actualizacion' => $fyh_actualizacion,
            ]);
        } catch (Exception $e) {
            echo "Error al crear el rol: " . $e->getMessage();
            return false;
        }
        return true;
    }

    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM tb_roles WHERE id_rol = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_rol, $nombre_rol, $fyh_actualizacion)
    {
        $sql = "UPDATE tb_roles SET nombre_rol = :nombre_rol, fyh_actualizacion = :fyh_actualizacion 
                WHERE id_rol = :id_rol";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'nombre_rol' => $nombre_rol,
                'fyh_actualizacion' => $fyh_actualizacion,
                'id_rol' => $id_rol
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el rol: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_rol)
    {
        $sql = "DELETE FROM tb_roles WHERE id_rol = :id_rol";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_rol' => $id_rol]);
        } catch (Exception $e) {
            echo "Error al eliminar el rol: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

}
?>
