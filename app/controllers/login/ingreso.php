<?php

include ("../../config.php");

$email = $_POST['email'];
$password_user = $_POST['password_user'];

$cont = 0;
$sql = "SELECT * FROM tb_usuarios WHERE email = '$email' and password_user = '$password_user'";
$query = $pdo->prepare($sql);
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    $cont = $cont + 1;
    $email_table = $user['email'];
    $names = $user['names'];
}

if($cont == 0){
    echo "Datos Incorrectos, vuelva a intentarlo";
    session_start();
    $_SESSION['message'] = 'Error: Datos Incorrectos'; //para los errores
    header('location: ' . $URL . '/login');
} else {
    echo "datos correctos";
    session_start();
    $_SESSION['sesion_email'] = $email; //esto va a estar en todo el sistema, con esto haremos consultas...
    header('location: '. $URL .'/index.php');
}



