<?php
include('app/config.php');
include($MODELS . 'tipo_pago.php');
$usuario = new Usuario();
$data_users = $usuario->Listar();
session_start();
include($VIEW.'tipo_pago.php'); 
