<?php
include('app/config.php');
include($MODELS . 'producto.php');
include($MODELS . 'categoria.php');
include($MODELS . 'caja.php');
include($MODELS . 'marcas.php');
include($MODELS . 'cliente.php');
$cliente = new Cliente();
$producto = new Producto();
$categoria = new Categoria();
$caja = new Caja();
$marcas = new Marcas();
//Para listar los productos
$data_catalogo = $producto->Listar();
$data_clientes = $cliente->Listar();
session_start();

//Para listar categorias en los selects

$data_categorias = $categoria->Listar();
$data_cajas = $caja->Listar();
$data_marcas = $marcas->Listar();
$data_productos = $producto->Listar();
include($VIEW.'catalogo.php'); 


