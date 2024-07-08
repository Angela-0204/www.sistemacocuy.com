<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../../connectDB.php');
require_once('../../models/rol.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_rol = $_POST['nombre_rol'];

    if (!empty($nombre_rol)) {
        $rol = new Rol();
        if($rol->Crear($nombre_rol)) {
            header('Location: ../../../roles.php');
        } else {
            echo "Error al crear el rol.";
        }
        exit();
    } else {
        echo "El nombre del rol es obligatorio.";
    }
}
?>

