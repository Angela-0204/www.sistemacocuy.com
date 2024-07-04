<?php

include('app/config.php'); 
$pagina = "homepage";

if (!empty($_GET['pagina'])){ 
 $pagina = $_GET['pagina']; 
}

if(is_file($CONTROLLER.$pagina.".php")){ 
 require_once($CONTROLLER.$pagina.".php");
}
else{
    echo 'No se encuentra el archivo';
}

?>