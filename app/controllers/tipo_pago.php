<?php
include('app/config.php');
include($MODELS . 'tipo_pago.php');
$data_tipo = new Tipo();
$data_tipos = $data_tipo->Listar();
session_start();
include($VIEW.'tipo_pago.php'); 
