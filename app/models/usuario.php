<?php
include('app/connectDB.php'); 

class Usuario extends connectDB
{
    public function ValidarIngreso($email, $clave)
    {
        $resultado = $this->conex->prepare("SELECT *FROM tb_usuarios WHERE email ='$email' AND password_user='$clave'; ");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT *FROM tb_usuarios");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear()
    {

    }

    public function Eliminar()
    {

    }

    public function Modificar()
    {

    }
}
