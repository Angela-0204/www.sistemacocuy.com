<?php
include('app/config.php');
include($MODELS . 'usuario.php');

$usuario = new Usuario();
if(isset($_POST['accion'])){
    $users = $usuario->ValidarIngreso($_POST['email'], $_POST['password_user']);
    $cont = 0;
    foreach ($users as $user) {
        $cont = $cont + 1;
        $names = $user['names'];
        $id = $user['id_users'];
        $rol = $user['cod_tipo_usuario'];
         
    }
    if ($cont == 0) {
        echo json_encode([
            'estatus' => '0',
            'icon' => 'error',
            'title' => 'Disculpe',
            'message' => 'Datos erroneos'
        ]);
        return 0;
    } else {
        session_start();
        $_SESSION['sesion_email'] = $names;
        $_SESSION['id_user'] = $id;
        $_SESSION['rol'] = $rol;
        echo json_encode([
            'estatus' => '1',
            'icon' => 'success',
            'title' => 'Bienvenidos',
            'message' => 'Datos correcto'
        ]);
        
        return 0;
    }
}

include($VIEW . 'login.php');
