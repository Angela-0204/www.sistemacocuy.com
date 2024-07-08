<?php 
include('app/connectDB.php');

$db = new connectDB();
$pdo = $db->getConnection();

$sql_rol = "SELECT * FROM tb_roles";
$query_rol = $pdo->prepare($sql_rol);
$query_rol->execute();
$rol_datos = $query_rol->fetchAll(PDO::FETCH_ASSOC);
session_start();
?>