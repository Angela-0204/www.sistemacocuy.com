<?php
include('app/config.php');
include($MODELS . 'producto.php');
include($MODELS . 'categoria.php');
include($MODELS . 'caja.php');
include($MODELS . 'marcas.php');
include($MODELS . 'pedido.php');
$pedido = new Pedido();
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
$data_pedido = $pedido->Listar();
include($VIEW.'lista_pedido.php'); 


