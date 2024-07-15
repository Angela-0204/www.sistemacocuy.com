<?php 
include('app/connectDB.php');
session_start();
$db = new connectDB();
$pdo = $db->getConnection();

$sql_almacen = "SELECT * FROM almacen";
$query_almacen = $pdo->prepare($sql_almacen);
$query_almacen->execute();
$datos_almacen = $query_almacen->fetchAll(PDO::FETCH_ASSOC);
?>