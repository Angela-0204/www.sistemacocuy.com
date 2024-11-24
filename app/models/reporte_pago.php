<?php
require_once(__DIR__ . '/../connectDB.php');

class Reporte_pago extends connectDB
{
   
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT p.nro_pago, p.fyh_pago, p.monto, dp.id_detalle_pago, dp.id_pedido, p.referencia, b.nombre_banco, tp.nombre AS tipo_pago, cl.nombre_cliente, cl.apellido, u.names as usuario FROM pago AS p INNER JOIN detalle_pago AS dp ON dp.nro_pago = p.nro_pago INNER JOIN banco AS b ON b.id_banco = p.id_banco INNER JOIN tipo_pago AS tp ON tp.id_tipo_pago = b.id_tipo_pago INNER JOIN pedido AS ped ON ped.id_pedido = dp.id_pedido INNER JOIN cliente AS cl ON cl.cod_cliente = ped.cod_cliente INNER JOIN usuario AS u on ped.id_users= u.id_users;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function GenerarReporte()
    {
        $resultado = $this->conex->prepare("SELECT p.nro_pago as Pago, p.fyh_pago as Fecha, p.monto as Monto,  p.referencia as Rerefencia, b.nombre_banco as Banco, tp.nombre AS Metodo, cl.nombre_cliente as Cliente, u.names as Usuario FROM pago AS p INNER JOIN detalle_pago AS dp ON dp.nro_pago = p.nro_pago INNER JOIN banco AS b ON b.id_banco = p.id_banco INNER JOIN tipo_pago AS tp ON tp.id_tipo_pago = b.id_tipo_pago INNER JOIN pedido AS ped ON ped.id_pedido = dp.id_pedido INNER JOIN cliente AS cl ON cl.cod_cliente = ped.cod_cliente INNER JOIN usuario AS u on ped.id_users= u.id_users;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function Crear($fyh_pago, $monto,  $referencia, $id_banco, $id_pedido)
    {
        // SQL para insertar en la tabla detalle_pago
        $sql_pago = "INSERT INTO pago (fyh_pago, monto, referencia, id_banco)
                VALUES (:fyh_pago, :monto, :referencia, :id_banco)";
        // Preparamos la consulta
        $resultado_pago = $this->conex->prepare($sql_pago);
        try {
            // Ejecutamos el primer INSERT en pago
            $resultado_pago->execute([
                'fyh_pago' => $fyh_pago,
                'monto' => $monto,
                'id_banco' => $id_banco,
             
                'referencia' => $referencia
                
            ]);           
    
            // Obtener el ID generado del último registro insertado en inventario
            $nro_pago = $this->conex->lastInsertId();
            $sql_detalle_pago = "INSERT INTO detalle_pago(nro_pago, id_pedido)
 
                VALUES (:nro_pago, :id_pedido)";
            // Preparamos la consulta para detalle_inventario
            $resultado_detalle_pago = $this->conex->prepare($sql_detalle_pago);
    
            // Ejecutamos el segundo INSERT en detalle_inventario con el cod_inventario obtenido
            $resultado_detalle_pago->execute([
                'nro_pago' => $nro_pago,
                'id_pedido' => $id_pedido
              
                
                             
            ]);
    
            return true;  // Todo se ejecutó correctamente
        } catch (Exception $e) {
            echo "Error al registrar el pago: " . $e->getMessage();
            return false;
        }
    }
    
    public function Buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM pago WHERE nro_pago = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function Eliminar($nro_pago)
    {
        // Iniciar la transacción para asegurar que ambas eliminaciones ocurren juntas
        $this->conex->beginTransaction();
    
        try {
            // Primero, eliminar los detalles asociados en la tabla detalle_pago
            $sqlDetallePago = "DELETE FROM detalle_pago WHERE nro_pago = :nro_pago";
            $stmtDetallePago = $this->conex->prepare($sqlDetallePago);
            $stmtDetallePago->execute(['nro_pago' => $nro_pago]);
    
            // Luego, eliminar el pago en la tabla pago
            $sqlPago = "DELETE FROM pago WHERE nro_pago = :nro_pago";
            $stmtPago = $this->conex->prepare($sqlPago);
            $stmtPago->execute(['nro_pago' => $nro_pago]);
    
            // Confirmar la transacción
            $this->conex->commit();
            return true;
    
        } catch (Exception $e) {
            // En caso de error, revertir la transacción
            $this->conex->rollBack();
            echo "Error al eliminar el pago y sus detalles: " . $e->getMessage();
            return false;
        }
    }
    

}
?>