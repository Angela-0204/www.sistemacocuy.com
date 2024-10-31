<?php
include('app/connectDB.php'); 

class Cliente extends connectDB
{
    private $cod_cliente;
    private $cedula_rif;
    private $nombre_cliente;
    private $apellido;
    private $correo;
    private $direccion;
    private $telefono;
    private $estatus;

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

    public function Crear($cedula_rif, $nombre_cliente, $apellido, $correo, $direccion, $telefono, $estatus)
    {
        // Iniciar una transacción
        $this->conex->beginTransaction();
        
        $resultado = $this->conex->prepare("INSERT INTO cliente (cedula_rif, nombre_cliente, apellido, correo, direccion, telefono, estatus) 
                                            VALUES (:cedula_rif, :nombre_cliente, :apellido, :correo, :direccion, :telefono, :estatus)");
        try {
            $resultado->execute([
                'cedula_rif' => $cedula_rif,
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

    public function Existe($cedula_rif)
    {
        $resultado = $this->conex->prepare("SELECT * FROM cliente WHERE cedula_rif = :cedula_rif");
        $resultado->execute(['cedula_rif' => $cedula_rif]);
        return $resultado->rowCount() > 0; // Retorna verdadero si existe
    }

    public function ExistePorId($cod_cliente)
    {
        $resultado = $this->conex->prepare("SELECT * FROM cliente WHERE cod_cliente = :cod_cliente");
        $resultado->execute(['cod_cliente' => $cod_cliente]);
        return $resultado->rowCount() > 0; // Retorna verdadero si existe
    }

    public function Buscar($cedula_rif)
    {
        $resultado = $this->conex->prepare("SELECT * FROM cliente WHERE cedula_rif = :cedula_rif");
        $resultado->execute(['cedula_rif' => $cedula_rif]);
        return $resultado->fetchAll();
    }

    public function Modificar($cedula_rif, $nombre_cliente, $apellido, $correo, $direccion, $telefono, $estatus)
    {
        $sql = "UPDATE cliente SET nombre_cliente = :nombre_cliente, apellido = :apellido, correo = :correo, direccion = :direccion, telefono = :telefono, estatus = :estatus
                WHERE cedula_rif = :cedula_rif";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'cedula_rif' => $cedula_rif,
                'nombre_cliente' => $nombre_cliente,
                'apellido' => $apellido,
                'correo' => $correo,
                'direccion' => $direccion,
                'telefono' => $telefono,
                'estatus' => $estatus
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el Cliente: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($cod_cliente)
    {
        $resultado = $this->conex->prepare("DELETE FROM cliente WHERE cod_cliente = :cod_cliente");
        return $resultado->execute(['cod_cliente' => $cod_cliente]);
    }
}
