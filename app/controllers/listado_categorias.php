<?php 
include('app/connectDB.php');
session_start();
// Verificar si la sesión está activa
if (!isset($_SESSION['id_user'])) {
    // Si no está iniciada la sesión, redirigir al login
    header('Location: ?pagina=login');
    exit();  // Asegura que no se ejecute el código restante de la página
}
$db = new connectDB();
$pdo = $db->getConnection();

$sql_categorias = "SELECT * FROM tb_categorias";
$query_categorias = $pdo->prepare($sql_categorias);
$query_categorias->execute();
$categorias_datos = $query_categorias->fetchAll(PDO::FETCH_ASSOC);
?>
