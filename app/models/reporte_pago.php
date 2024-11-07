<?php
require_once(__DIR__ . '/../connectDB.php');

class Reporte_pago extends connectDB
{
   
    public function Listar()
    {
        $resultado = $this->conex->prepare("SELECT a.nro_pago, a.fyh_pago, a.monto, a.id_detalle_pago, a.id_pedido c.referencia, d.nombre FROM pago a INNER JOIN detalle_pago c ON c.id_detalle_pago=a.id_detalle_pago INNER JOIN tipo_pago d ON d.id_tipo_pago=c.id_tipo_pago;");
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
