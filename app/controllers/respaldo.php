<?php
include('app/config.php');
include($MODELS . 'usuario.php');
$usuario = new Usuario();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    switch($accion)
    {
        case 'ingresar':
        $users = $usuario->ValidarIngreso($_POST['email'], $_POST['password_user']);
        $cont = 0;
        foreach ($users as $user) {
            $cont = $cont + 1;
            //$email = $user['email'];
            //$names = $user['names'];
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
            echo json_encode([
                'estatus' => '1',
                'icon' => 'success',
                'title' => 'Bienvenidos',
                'message' => 'Datos correcto'
            ]);
            
            return 0;
        }
    }
    
}
include($VIEW . 'login.php');
