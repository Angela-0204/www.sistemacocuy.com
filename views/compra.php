<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>
    <link rel="stylesheet" href="<?php echo $URL;?>/public/css/compra.css">
</head>
<body>
    <header class="header">
        <div class="menu contenedor">
            <a href="#" class="logo">Cocuy Leal</a>
            <!-- Navigation and other header content -->
        </div>
        <div class="submenu">
        <ul>
            <li >
                <img src="<?php echo $URL;?>/public/images/perfil.png" id="img-perfil" alt="carrito">
                <div id="perfil">
                    <table id="lista-perfil">
                        <thead>
                            <tr>
                            
                            <th>Cerrar &nbsp;&nbsp;Sesión</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                     <a href="?pagina=homepage" id="salir-vendedor" class="btn-2">Salir</a>
                </div>
            </li>
        </ul>
    </div>
   </div>


    </header>

    <main class="container">
        <h2>Gestionar Compra</h2>
        <table id="tabla-carrito">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="contenido-carrito"></tbody>
        </table>
        <div id="total">
            <h3>Total: $<span id="total-precio">0</span></h3>
        </div>
        <button id="btn-finalizar-compra">Finalizar Compra</button>
    </main>

    <script src="<?php echo $URL;?>/public/js/compra.js"></script>
</body>
</html>
