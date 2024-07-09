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
        $resultado = $this->conex->prepare("SELECT * FROM tb_usuarios INNER JOIN tb_roles ON tb_usuarios.id_rol=tb_roles.id_rol;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($names, $email, $password_user, $fyh_creation, $id_rol)
    {
        $resultado = $this->conex->prepare("INSERT INTO tb_usuarios (names, email, password_user, fyh_creation, id_rol) VALUES (:names, :email, :password_user, :fyh_creation, :id_rol)");
        try {
            $resultado->execute([
                'names' => $names,
                'email' => $email,
                'password_user' => $password_user,
                'fyh_creation' => $fyh_creation,
                'id_rol' => $id_rol
            ]);
        } catch (Exception $e) {
            echo "Error al crear el usuario: " . $e->getMessage();
            return false;
        }
        return true;
    }

    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM tb_usuarios WHERE id_users = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_users, $names, $email, $password_user, $id_rol)
    {
        $sql = "UPDATE tb_usuarios SET names = :names, email = :email, password_user = :password_user  , id_rol = :id_rol  
                WHERE id_users = :id_users";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'names' => $names,
                'email' => $email,
                'password_user' => $password_user,
                'id_rol' => $id_rol,
                'id_users' => $id_users
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el rol: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_users)
    {
        $sql = "DELETE FROM tb_usuarios WHERE id_users = :id_users";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_users' => $id_users]);
        } catch (Exception $e) {
            echo "Error al eliminar el rol: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
}
