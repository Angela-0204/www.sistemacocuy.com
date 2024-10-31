<?php
 function Crear($names, $email, $password_user, $fyh_creation, $id_rol)
{
    try {
        // Iniciar transacción
        $this->conex->beginTransaction();

        // Verificar si el email ya existe
        $stmt = $this->conex->prepare("SELECT * FROM tb_usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            throw new Exception("El correo electrónico ya está registrado.");
        }

        // Insertar usuario
        $resultado = $this->conex->prepare("INSERT INTO tb_usuarios (names, email, password_user, fyh_creation, id_rol) 
                                            VALUES (:names, :email, :password_user, :fyh_creation, :id_rol)");
        $resultado->execute([
            'names' => $names,
            'email' => $email,
            'password_user' => password_hash($password_user, PASSWORD_BCRYPT), // Encriptar contraseña
            'fyh_creation' => $fyh_creation,
            'id_rol' => $id_rol
        ]);

        // Si todo está bien, confirmar la transacción
        $this->conex->commit();
        return true;
    } catch (Exception $e) {
        // Si hay un error, revertir todo
        $this->conex->rollBack();
        return "Error al crear el usuario: " . $e->getMessage();
    }
}
