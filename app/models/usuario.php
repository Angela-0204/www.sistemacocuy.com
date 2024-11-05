<?php
include('app/connectDB.php'); 

class Usuario extends connectDB
{
    private $cod_tipo_usuario;
    private $rol;

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
        $resultado = $this->conex->prepare("SELECT a.id_users, a.names, a.email, a.password_user, c.rol, c.cod_tipo_usuario FROM usuario a INNER JOIN tipo_usuario c ON a.cod_tipo_usuario=c.cod_tipo_usuario;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    public function VerificarCorreo($email)
{
    $sql = "SELECT COUNT(*) as count FROM usuario WHERE email = :email";
    $resultado = $this->conex->prepare($sql);

    try {
        $resultado->execute(['email' => $email]);
        $count = $resultado->fetch(PDO::FETCH_ASSOC)['count'];
    } catch (Exception $e) {
        return false;
    }

    return $count > 0;
}




    public function Crear($names, $email, $password_user, $cod_tipo_usuario)
    {
        // Iniciar una transacción
        $this->conex->beginTransaction();
    
        $resultado = $this->conex->prepare("INSERT INTO usuario (names, email, password_user, cod_tipo_usuario) 
                                            VALUES (:names, :email, :password_user,  :cod_tipo_usuario)");
        try {
            $resultado->execute([
                'names' => $names,
                'email' => $email,
                'password_user' => $password_user,
                'cod_tipo_usuario' => $cod_tipo_usuario
               
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

    public function Modificar($id_users, $names, $email, $password_user, $cod_tipo_usuario)
    {
        $sql = "UPDATE usuario SET names = :names, email = :email, password_user = :password_user, cod_tipo_usuario = :cod_tipo_usuario
                WHERE id_users = :id_users";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'names' => $names,
                'email' => $email,
                'password_user' => $password_user,
                 'cod_tipo_usuario' => $cod_tipo_usuario,
                 
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
            echo "Error al eliminar el usuario: " . $e->getMessage();
            return false;
        }
        
        return true;
    }
}
