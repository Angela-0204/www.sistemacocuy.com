<?php
include('app/config.php');
include($MODELS . 'cliente.php');

$cliente = new Cliente();
$data_cliente = $cliente->Listar();

session_start();

if (isset($_POST['accion'])) {
    // Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch ($_POST['accion']) {
        // Para registrar
        case 'registrar':
            $cedula_rif = $_POST['cedula_rif'];
            $nombre_cliente = $_POST['nombre_cliente'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['operadora'].'-'.$_POST['telefono'];
            $estatus = $_POST['estatus'];
            
            $response = array();
        
            // Validaciones en el lado del servidor
            if (empty($cedula_rif) || empty($nombre_cliente) || empty($apellido) || empty($correo) || empty($direccion) || empty($telefono) || empty($estatus)) {
                $response['estatus'] = 0;
                $response['mensaje'] = "Todos los campos son obligatorios.";
                echo json_encode($response);
                return 0;
            }
        
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $response['estatus'] = 0;
                $response['mensaje'] = "Por favor, ingrese un email válido.";
                echo json_encode($response);
                return 0;
            }

            // Verificar si el cliente ya está registrado
            $validar = $cliente->Existe($cedula_rif);
            
            if ($validar) {
                $response['estatus'] = 0;
                $response['mensaje'] = "El cliente con esta cédula o RIF ya está registrado.";
                echo json_encode($response);
                return 0;
            }
        
            $result = $cliente->Crear($cedula_rif, $nombre_cliente, $apellido, $correo, $direccion, $telefono, $estatus);
            
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Cliente registrado exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar el cliente.";
            }
            
            echo json_encode($response);
            return 0;
        break;

        // Para consultar el registro a modificar
        case 'consultar':
            $data = $cliente->Buscar($_POST['cedula_rif']);
            foreach ($data as $valor) {
                echo json_encode([
                    'cedula_rif' => $valor['cedula_rif'],
                    'nombre_cliente' => $valor['nombre_cliente'],
                    'apellido' => $valor['apellido'],
                    'correo' => $valor['correo'],
                    'direccion' => $valor['direccion'],
                    'telefono' => $valor['telefono'],
                    'estatus' => $valor['estatus']
                ]);
            }
            exit;
        break;
        // Para eliminar un registro
        case 'eliminar':
            $cod_cliente = $_POST['cod_cliente'];
            // Validar si el cliente existe antes de intentar eliminar
            if (!$cliente->ExistePorId($cod_cliente)) {
                $response['estatus'] = 0;
                $response['mensaje'] = "No se puede eliminar: el cliente no existe.";
                echo json_encode($response);
                return;
            }

            $result = $cliente->Eliminar($cod_cliente);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Cliente eliminado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar el cliente.";
            }
            echo json_encode($respuesta);
            return;

        // Para modificar los datos
        case 'modificar':
            $cedula_rif = $_POST['cedula_rif'];
            $nombre_cliente = $_POST['nombre_cliente'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $estatus = $_POST['estatus'];

            // Validar que el cliente exista antes de modificar
            if (!$cliente->Existe($cedula_rif)) {
                $response['estatus'] = 0;
                $response['mensaje'] = "No se puede modificar: el cliente no existe.";
                echo json_encode($response);
                return;
            }

            $result = $cliente->Modificar($cedula_rif, $nombre_cliente, $apellido, $correo, $direccion, $telefono, $estatus);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Cliente modificado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar el cliente.";
            }
            echo json_encode($respuesta);
            return;
    }
}
include($VIEW.'cliente.php'); 
