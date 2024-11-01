<?php
include('app/config.php');
include($MODELS . 'producto.php');
include($MODELS . 'categoria.php');
include($MODELS . 'caja.php');
include($MODELS . 'marcas.php');
$producto = new Producto();
$categoria = new Categoria();
$caja = new Caja();
$marcas = new Marcas();
//Para listar los productos
$data_catalogo = $producto->Listar();
session_start();

//Para listar categorias en los selects

$data_categorias = $categoria->Listar();
$data_cajas = $caja->Listar();
$data_marcas = $marcas->Listar();
include($VIEW.'catalogo.php'); 


