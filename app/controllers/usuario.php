<?php
include('app/config.php');
include($MODELS . 'usuario.php');
$usuario = new Usuario();
$data_users = $usuario->Listar();
session_start();
include($VIEW.'usuario.php'); 

