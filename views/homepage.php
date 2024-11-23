<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocuy Leal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo $URL;?>/public/css/index.css">
</head>

<body>

    <header>
        <div class="menu container">

            <img class="logo-1" src="<?php echo $URL;?>/public/images/logococuy.png" alt="">
            <input type="checkbox" id="menu" />
            <label for="menu">
                <img src="<?php echo $URL;?>/public/images/menu.png" alt="" class="menu-icono">
            </label>
            <nav class="navbar">

                <div class="menu-1">
                    <ul>
                        <li><a href="?pagina=login">Iniciar Sesion</a></li>
                        
                    </ul>
                </div>
                <img class="logo-2 dark" src="<?php echo $URL;?>/public/images/logococuy.png" alt="">
                <img class="logo-2 claro" src="<?php echo $URL;?>/public/images/cocuy-removebg-preview.png" alt="">
                <div class="menu-2">
                    <ul>
                      <li><a href="?pagina=catalogo">Catalogo</a></li>
                       <li class="switch">
                        <i class='bx bxs-sun'></i>
                        <i class='bx bxs-moon'></i>
                    </li>
                    
                    </ul>

                </div>
            </nav>
        </div>
        <div class="header-content container">

            <div class="swiper mySwiper-1">

                <div class="swiper-wrapper">

                    <div class="swiper-slide">

                        <div class="slider">
                            <div class="slider-txt">
                                <h1>Cocuy Sour</h1>
                                <p>Prueba nuestros deliciosos cocteles Cocktail</p>
                
                                <div class="botones">
                                    <a href="#" class="btn-1">Comprar</a>
                                    <a href="#" class="btn-1">Mas</a>
                                </div>
                            </div>
                            <div class="slider-img ">
                                <img src="<?php echo $URL;?>/public/images/coctel2.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="slider">
                            <div class="slider-txt">
                                <h1>Aguardiente</h1>
                                <p>Prueba nuestro delicioso Aguardiente El DR.</p>
                                <div class="botones">
                                    <a href="#" class="btn-1">Comprar</a>
                                    <a href="#" class="btn-1">Mas</a>
                                </div>
                            </div>
                            <div class="slider-img ">
                                <img src="<?php echo $URL;?>/public/images/el doctor.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">

                        <div class="slider">
                            <div class="slider-txt">
                                <h1>Aguardiente</h1>
                                <p>Disfruta de nuestro delicioso Aguardiente el platino</p>
                                <div class="botones">
                                    <a href="#" class="btn-1">Comprar</a>
                                    <a href="#" class="btn-1">Mas</a>
                                </div>
                            </div>
                            <div class="slider-img ">
                                <img src="<?php echo $URL;?>/public/images/platino2-removebg-preview.png" alt="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>



            </div>



        </div>


    </header>
    <section class="info container">
        <div class="info-img">
            <img src="<?php echo $URL;?>/public/images/fondoinfo-removebg-preview.png" alt="">
        </div>
        <div class="info-txt">
            <h2>Informacion</h2>
            <p>Somos una empresa dedica a la destileria de licores a base de cocuy, tenemos un gran variedad de repoductos y experiencia en el area</p>
                <a href="https://cocuyleal.com/nosotros/" class="btn-2">Mas informacion</a>
        </div>
    </section>
    <section class="horario">
        <div  class="horario-info container">
           
            <div class="horario-txt">
                <div class="txt">
                <h4>Direccion</h4>
                <p>Carrera 12 </p>
                <p>Entre calles 36 y 37</p>
            </div>
            <div class="txt">
                <h4>Horario</h4>
                <p>lunes a viernes:  8am - 5pm </p>
            
            </div>
            <div class="txt">
                <h4>Telefono</h4>
                <p>0251-38383993 </p>
            </div>
            <div class="txt">
                <h4>Redes Sociales</h4>
                <div class="socials">
                <a href="https://www.facebook.com/profile.php?id=100092070954105">
                    <div class="social">
                        <img src="<?php echo $URL;?>/public/images/s1.svg" alt="">
                    </div>
                </a>
               
                <a href="https://www.instagram.com/cocuyleal/">
                    <div class="social">
                        <img src="<?php echo $URL;?>/public/images/s3.svg" alt="">
                    </div>
                </a>
            </div>

            </div>
            </div>
        </div>
    </section>
    <section>
        <iframe class="map"   src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d406.0209236471929!2d-69.32781782001253!3d10.058694737044783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e8767cc0ab699c9%3A0x62fbf5f58e50fb22!2scocuy%20leal!5e1!3m2!1ses-419!2sus!4v1715289692884!5m2!1ses-419!2sus" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
     <footer class="footer container">
       <img class="logo-2" src="<?php echo $URL;?>/public/images/logococuy.png" alt="">
       <div class="links">
          <h4>loren</h4>
          <ul>
            <li><a href="#">loren</a></li>
            <li><a href="#">loren</a></li>
            <li><a href="#">loren</a></li>
            <li><a href="#">loren</a></li>
          </ul>
       </div>
       <div class="links">
        <h4>loren</h4>
        <ul>
          <li><a href="#">loren</a></li>
          <li><a href="#">loren</a></li>
          <li><a href="#">loren</a></li>
          <li><a href="#">loren</a></li>
        </ul>
     </div>
     <div class="links">
        <h4>loren</h4>
        <div class="socials">
            <a href="#">
                <div class="social">
                    <img src="<?php echo $URL;?>/public/images/s1.svg" alt="">
                </div>
            </a>
            <a href="#">

                <div class="social">
                    <img src="<?php echo $URL;?>/public/images/s2.svg" alt="">
                </div>
            </a>
            <a href="#">
                <div class="social">
                    <img src="<?php echo $URL;?>/public/images/s3.svg" alt="">
                </div>
            </a>
        </div>

     </div>
     </footer>



    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="<?php echo $URL;?>/public/js/script.js"></script>
    <script src="<?php echo $URL;?>/public/js/efecto.js"></script>
    
</body>

</html>           