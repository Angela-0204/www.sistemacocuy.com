<?php
include('app/config.php');
include($MODELS . 'usuario.php');

$usuario = new Usuario();
$data_users = $usuario->Listar();


session_start();

if(isset($_POST['accion'])){
    //Establecer zona horaria para obtener la fecha actual
    date_default_timezone_set('UTC');

    switch($_POST['accion']){
        //Para registrar
        case 'registrar':
            $names = $_POST['names'];
            $password_user = $_POST['password_user'];
            $password_repeat = $_POST['password_repeat'];
            $email = $_POST['email'];
            $fecha = date("Y-m-d H:i:s"); 
          
            $response = array();
        
            // Validaciones en el lado del servidor
            if (empty($names) || empty($password_user) || empty($password_repeat) || empty($email)) {
                $response['estatus'] = 0;
                $response['mensaje'] = "Todos los campos son obligatorios.";
                echo json_encode($response);
                return 0;
            }
        
            if ($password_user != $password_repeat) {
                $response['estatus'] = 0;
                $response['mensaje'] = "Las contraseñas no coinciden.";
                echo json_encode($response);
                return 0;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['estatus'] = 0;
                $response['mensaje'] = "Por favor, ingrese un email válido.";
                echo json_encode($response);
                return 0;
            }
        
        
            $result = $usuario->Crear($names, $email, $password_user, $fecha);
            
            if ($result) {
                $response['estatus'] = 1;
                $response['mensaje'] = "Usuario registrado exitosamente.";
            } else {
                $response['estatus'] = 0;
                $response['mensaje'] = "Error al registrar el usuario.";
            }
            
            echo json_encode($response);
            return 0;
        break;
        

        //Para consultar el registro a modificar
        case 'consultar':
            $data = $usuario->Buscar($_POST['id_usuario']);
            foreach ($data as $valor) {
                echo json_encode([
                    'id' => $valor['id_users'],
                    'names' => $valor['names'],
                    'email' => $valor['email'],
                    'password_user' => $valor['password_user']
                ]);
            }
            return 0;
        break;

        //Para eliminar un registro
        case 'eliminar':
            $result = $usuario->Eliminar($_POST['id']);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Usuario Eliminado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al eliminar la usuario.";
            }
            echo json_encode($respuesta);
            return 0;
        break;

        //Para modificar los datos
        case 'modificar':
            $id = $_POST['id'];
            $names = $_POST['names'];
            $password_user = $_POST['password_user'];
            $email = $_POST['email'];
          
        
            $result = $usuario->Modificar($id, $names, $email, $password_user, $email);
            $respuesta = array();
            if ($result) {
                $respuesta['estatus'] = 1;
                $respuesta['mensaje'] = "Usuario Modificado exitosamente.";
            } else {
                $respuesta['estatus'] = 0;
                $respuesta['mensaje'] = "Error al modificar la usuario.";
            }
            echo json_encode($respuesta);
            return 0;
        break;        

    }
}
include($VIEW.'usuario.php'); 

