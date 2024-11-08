<?php
include('app/config.php');
session_start();
// Verificar si la sesión está activa
if (!isset($_SESSION['id_user'])) {
    // Si no está iniciada la sesión, redirigir al login
    header('Location: ?pagina=login');
    exit();  // Asegura que no se ejecute el código restante de la página
}
include($VIEW.'inicio.php'); 

