<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/css/catalogo.css">
</head>

<body>

    <header class="header">
        <div class="menu container">
            <a href="#" class="logo">Cocuy Leal</a>
            <input type="checkbox" id="menu" />
            <label for="menu">
                <img src="<?php echo $URL; ?>/public/images/menu.png" class="menu-icono" alt="menu">
            </label>
            <nav class="navbar">
                <ul>
                    <?php foreach ($categorias as $categoria) { ?>
                        <li><a href="#<?=$categoria['id_categoria']?>"><?php echo $categoria['nombre_categoria']?></a></li>  
                    <?php } ?>

                </ul>
            </nav>
            <div>
                <ul>
                    <li class="submenu">
                        <img src="<?php echo $URL; ?>/public/images/carrito-removebg-preview.png" id="img-carrito" alt="carrito">
                        <div id="carrito">
                            <table id="lista-carrito">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <a href="?pagina=hacer_compra" id="comprar" class="btn-2">Comprar</a>
                            <a href="#" id="vaciar-carrito" class="btn-2">Vaciar Carrito</a>

                        </div>

                    </li>
                </ul>
            </div>
            <div>
                <ul>
                    <li class="submenu">
                        <img src="<?php echo $URL; ?>/public/images/perfil.png" id="img-carrito" alt="carrito">
                        <div id="perfil">
                            <table id="lista-perfil">
                                <thead>
                                    <tr>

                                        <th>Cerrar Sesion</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <a href="?pagina=login" id="salir-vendedor" class="btn-2">Salir</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="header-content container">
            <div class="header-img">
                <img src="<?php echo $URL; ?>/public/images/fondoinfo-removebg-preview.png" alt="">
            </div>
            <div class="header-txt">
                <h1>Realiza tus pedidos con nosotros</h1>
                <p>Disfruta de nuestros licores a base de cocuy</p>
               
            </div>
        </div>

    </header>
    
    <?php foreach ($categorias as $categoria) { ?>
    <main class="products container" id="lista-<?=$categoria['id_categoria']?>">
        <div id="<?=$categoria['id_categoria']?>">
            <h2><?php echo $categoria['nombre_categoria']?></h2>
        </div>
        <div class="product-content">
            <?php $productos = $producto->BuscarPorCategoria($categoria['id_categoria']);
            foreach ($productos as $data_producto) { ?>
                <div class="product">
                <img src="<?php echo $data_producto['imagen']; ?>" alt="">
                <div class="product-txt">
                    <h3><?php echo $data_producto['nombre']; ?></h3>
                    <p><?php echo $data_producto['descripcion']; ?></p>
                    <p class="precio"><?php echo $data_producto['precio_venta']; ?>$</p>
                    <a href="#" class="agregar-carrito btn-2" data-id="<?=$data_producto['id_producto']; ?>">Agregar al carrito</a>
                </div>
            </div>
            <?php }
            $productos = [];
            ?>

        </div>
    </main>
    <?php } ?>











    <section class="icons container">

        <div class="icon-1">
            <div class="icon-img">
                <img src="<?php echo $URL; ?>/public/images/botella logo.jpg" alt="">
            </div>
            <div class="icon-txt">
                <h3>Lorem ipsum dolor sit, amet consectetur.</h3>
                <p>Lorem ipsum dolor sit, amet consectetur</p>
            </div>
        </div>
        <div class="icon-1">
            <div class="icon-img">
                <img src="<?php echo $URL; ?>/public/images/coctel logo.jpg" alt="">
            </div>
            <div class="icon-txt">
                <h3>Lorem ipsum dolor sit, amet consectetur.</h3>
                <p>Lorem ipsum dolor sit, amet consectetur</p>
            </div>
        </div>

    </section>


    <script src="<?php echo $URL; ?>/public/js/carrito.js"></script>
</body>

</html>