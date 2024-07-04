<?php

include('app/config.php');

function loadPage($pagina) {
    $filePath = 'app/controllers/'. $pagina . '.php';
    if (file_exists($filePath)) {
        require_once($filePath);
    } else {
        redirectTo('homepage');
    }
}

function redirectTo($pagina) {
    $filePath = 'app/controllers/'. $pagina . '.php';
    if (file_exists($filePath)) {
        echo "<script>window.location = '?pagina=$pagina'</script>";
        exit();
    } else {
        echo "<script>window.location = '?pagina=Error404'</script>";
        exit();
    }
}

if (isset($pagina) && !empty($pagina)) {
    loadPage($pagina);
} else {
    redirectTo('homepage');
}

?>