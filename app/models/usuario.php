<?php
include('app/connectDB.php'); 

class Usuario extends connectDB
{
    public function ValidarIngreso($email, $clave)
    {
        $resultado = $this->conex->prepare("SELECT *FROM usuario WHERE email ='$email' AND password_user='$clave'; ");
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
        $resultado = $this->conex->prepare("SELECT * FROM usuario");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($names, $email, $password_user, $fyh_creation)
    {
        // Iniciar una transacción
        $this->conex->beginTransaction();
    
        $resultado = $this->conex->prepare("INSERT INTO usuario (names, email, password_user, fyh_creation) 
                                            VALUES (:names, :email, :password_user, :fyh_creation)");
        try {
            $resultado->execute([
                'names' => $names,
                'email' => $email,
                'password_user' => $password_user,
                'fyh_creation' => $fyh_creation
               
            ]);
    
            $this->conex->commit();
        } catch (Exception $e) {
        
            $this->conex->rollBack();
            echo "Error al crear el usuario: " . $e->getMessage();
            return false;
        }
        return true;
        
    }
    







    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE id_users = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($id_users, $names, $email, $password_user)
    {
        $sql = "UPDATE usuario SET names = :names, email = :email, password_user = :password_user 
                WHERE id_users = :id_users";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'names' => $names,
                'email' => $email,
                'password_user' => $password_user,

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
        $sql = "DELETE FROM usuario WHERE id_users = :id_users";
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
