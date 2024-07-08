<?php
include('app/config.php');
include($MODELS . 'producto.php');
session_start();
include($MODELS . 'categoria.php');
$producto = new Producto();
$categoria = new Categoria();
$categorias = $categoria->Listar();
//$data_products = $producto->BuscarPorCategoria();
include($VIEW.'catalogo.php'); 
