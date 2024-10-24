<?php
include('app/connectDB.php'); 

class Cliente extends connectDB
{
 

    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT * FROM cliente");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($cedula_cliente, $nombre_cliente, $apellido, $correo, $direccion, $telefono, $estatus)
    {
        // Iniciar una transacción
        $this->conex->beginTransaction();
        
        $resultado = $this->conex->prepare("INSERT INTO cliente (cedula_cliente, nombre_cliente, apellido, correo, direccion, telefono, estatus) 
                                            VALUES (:cedula_cliente, :nombre_cliente, :apellido, :correo, :direccion, :telefono, :estatus)");
        try {
            $resultado->execute([
                'cedula_cliente' => $cedula_cliente,
                'nombre_cliente' => $nombre_cliente,
                'apellido' => $apellido,
                'correo' => $correo,
                'direccion' => $direccion,
                'telefono' => $telefono,
                'estatus' => $estatus
            ]);
        
            $this->conex->commit();
        } catch (Exception $e) {
            // En caso de error, hacer rollback y mostrar el error
            $this->conex->rollBack();
            echo "Error al crear el cliente: " . $e->getMessage();
            return false;
        }
        return true;
    }
    






    public function Buscar($codigo_cliente)
    {
        $resultado = $this->conex->prepare("SELECT * FROM cliente WHERE codigo_cliente = '$codigo_cliente'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Modificar($codigo_cliente,$cedula_cliente, $nombre_cliente, $apellido, $correo, $direccion, $telefono, $estatus)
    {
        $sql = "UPDATE cliente SET cedula_cliente = :cedula_cliente, nombre_cliente = :nombre_cliente, apellido = :apellido, correo = :correo, direccion = :direccion, telefono = :telefono, estatus = :estatus
                WHERE codigo_cliente = :codigo_cliente";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'cedula_cliente' => $cedula_cliente,
                'nombre_cliente' => $nombre_cliente,
                'apellido' => $apellido,
                'correo' => $correo,
                'direccion' => $direccion,
                'telefono' => $telefono,
                'estatus' => $estatus,

                'codigo_cliente' => $codigo_cliente
                
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el Cliente: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($codigo_cliente)
    {
        $sql = "DELETE FROM cliente WHERE codigo_cliente = :codigo_cliente";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['codigo_cliente' => $codigo_cliente]);
        } catch (Exception $e) {
            echo "Error al eliminar el cliente " . $e->getMessage();
            return false;
        }
        
        return true;
    }
}
