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

    public function Crear($fyh_pago, $monto, $id_tipo_pago,  $referencia)
    {
        // SQL para insertar en la tabla detalle_pago
        $sql_detalle_pago = "INSERT INTO detalle_pago (id_tipo_pago, referencia)
                VALUES (:id_tipo_pago, :referencia)";
        // Preparamos la consulta
        $resultado_detalle_pago = $this->conex->prepare($sql_detalle_pago);
    
        try {
            // Ejecutamos el primer INSERT en inventario
            $resultado_detalle_pago->execute([

                'id_tipo_pago' => $id_tipo_pago,
             
                'referencia' => $referencia
                
            ]);           
    
            // Obtener el ID generado del último registro insertado en inventario
            $nro_pago = $this->conex->lastInsertId();
            $sql_detalle_pago = "INSERT INTO pago (id_detalle_pago, fyh_pago, monto)
 
                VALUES (:id_detalle_pago, :fyh_pago, :monto)";
            // Preparamos la consulta para detalle_inventario
            $resultado_detalle_pago = $this->conex->prepare($sql_detalle_pago);
    
            // Ejecutamos el segundo INSERT en detalle_inventario con el cod_inventario obtenido
            $resultado_detalle_pago->execute([
                'id_detalle_pago' => $nro_pago,
                'fyh_pago' => $fyh_pago,
                'monto' => $monto,
                'id_tipo_pago' => $id_tipo_pago,
          
                'referencia' => $referencia
                
                             
            ]);
    
            return true;  // Todo se ejecutó correctamente
        } catch (Exception $e) {
            echo "Error al crear el producto: " . $e->getMessage();
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

    public function Modificar($id_categoria, $nombre_categoria)
    {
        $sql = "UPDATE categoria SET nombre_categoria = :nombre_categoria
                WHERE id_categoria = :id_categoria";
            
        $resultado = $this->conex->prepare($sql);
        try {
            $resultado->execute([
                'nombre_categoria' => $nombre_categoria,
                
                'id_categoria' => $id_categoria
            ]);
        } catch (Exception $e) {
            echo "Error al modificar el producto: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

    public function Eliminar($id_categoria)
    {
        $sql = "DELETE FROM categoria WHERE id_categoria = :id_categoria";
        $resultado = $this->conex->prepare($sql);
        
        try {
            $resultado->execute(['id_categoria' => $id_categoria]);
        } catch (Exception $e) {
            echo "Error al eliminar la categoria: " . $e->getMessage();
            return false;
        }
        
        return true;
    }

}
?>
