<?php
require 'php/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Michael Jackson Store</title>
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="preload" href="css/normalize.css" as="style">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="preload" href="css/styles.css" as="style">
    <link href="css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <!-- Navegación -->
        <div class="nav-bg">
            <nav class="navegacion-principal">
                <a href="index.html" class="logo"><span>MJ</span>Records</a>
                <!--Buscador-->
                <div class="buscar">

                    <input type="text" placeholder="Buscar" required>

                    <div class="btn">
                        <i class="fas fa-search icon" id="icono"></i>
                    </div>

                    <a href="contacto.html"><i class="bx bx-phone" id="contacto"></i></a>

                    <!--Iconos de cart-->
                    <i class="bx bx-shopping-bag" id="cart-icon"></i>

                </div>

                <!--Cart-->
                <div class="cart">
                    <h2 class="cart-title">Carrito</h2>

                    <!--Contenido del carrito (cart)-->
                    <div class="cart-content">


                    </div>

                    <!--Total del carro-->
                    <div class="total">
                        <button type="button" class="btn-buy">Comprar Ahora</button>
                        <div class="total-title"> Total</div>
                        <div class="total-price"> $0</div>

                    </div>



                    <!--Cierre del carrito-->
                    <i class="bx bx-x" id="cart-close"></i>

                </div>
            </nav>
        </div>
    </header>

    <div class="encabezado-img">
        <h2>MICHAEL JACKSON</h2>
        <p>¡Adquiere todo lo necesario del rey del pop!</p>
    </div>

    <div>
        <h2 class="title-albumes">Consigue todos sus Álbumes</h2>
    </div>

    <!--Area donde estan todos los vinilos-->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

            <div class="swiper-slide">
                <div class="icons">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                    <img src="#" alt="">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="titulodisco">Off the wall</h3>
                <div>
                    <p class="lista">Lista de canciones</p>
                </div>
                <div class="product-content">
                    <div class="product-txt">
                        <p>1.Don't Stop 'Til You Get Enough</p>
                        <p>2.Rock with You</p>
                        <p>3.Workin' Day and Night</p>
                        <p>4.Get on the Floor</p>
                        <p>>.Off the Wall</p>
                        <p>6.Girlfriend</p>
                        <p>7.I Can't Help It</p>
                        <p>8.Burn This Disco Out</p>
                    </div>
                    <div class="product-img">
                        <img src="Imagenes/off the wall.webp" alt="">
                    </div>
                </div>
                <div>
                    <h2 class="precio">$1,500.00</span>
                </div>
                <a href="php/paypal.php" class="btn-1">Comprar</a>
            </div>

            <div class="swiper-slide">
                <div class="icons">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                    <img src="#" alt="">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="titulodisco">Thriller</h3>
                <div>
                    <p class="lista">Lista de canciones</p>
                </div>
                <div class="product-content">
                    <div class="product-txt">
                        <p> 1.Wanna Be Startin' Somethin'</p>
                        <p> 2.Baby Be Mine</p>
                        <p>3.The Girl Is Mine</p>
                        <p>4.Thriller</p>
                        <p>5.Beat It</p>
                        <p>6.P.Y.T. (Pretty Young Thing)</p>
                        <p>7.For All Time</p>
                        <p>8.Human Nature</p>
                    </div>
                    <div class="product-img">
                        <img src="Imagenes/Thriller.webp" alt="">
                    </div>
                </div>
                <div>
                    <h2 class="precio">$1,600.00</span>
                </div>
                <a href="php/paypal.php" class="btn-1">Comprar</a>
            </div>

            <div class="swiper-slide">
                <div class="icons">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                    <img src="#" alt="">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="titulodisco">Dangerous</h3>
                <div>
                    <p class="lista">Lista de canciones</p>
                </div>
                <div class="product-content">
                    <div class="product-txt">
                        <p> 1.Jam</p>
                        <p> 2.Why You Wanna Trip on Me</p>
                        <p> 3.In the Closet</p>
                        <p> 4.She Drives Me Wild</p>
                        <p> 5.Can't Let Her Get Away</p>
                        <p> 6.Heal the World</p>
                        <p> 7.Who Is It</p>
                        <p> 8.Keep the Faith</p>
                    </div>
                    <div class="product-img">
                        <img src="Imagenes/Dangerous.webp" alt="">
                    </div>
                </div>
                <div>
                    <h2 class="precio">$1,250.00</span>
                </div>
                <a href="php/paypal.php" class="btn-1">Comprar</a>
            </div>

            <div class="swiper-slide">
                <div class="icons">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                    <img src="#" alt="">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="titulodisco">Bad</h3>
                <div>
                    <p class="lista">Lista de canciones</p>
                </div>
                <div class="product-content">
                    <div class="product-txt">
                        <p>1.The Way You Make Me Feel</p>
                        <p>2.Speed Demon</p>
                        <p>3.Liberian Girl</p>
                        <p>4.Just Good Friends</p>
                        <p>5.Another Part of Me</p>
                        <p>6.Man in the Mirror</p>
                    </div>
                    <div class="product-img">
                        <img src="Imagenes/Bad.webp" alt="">
                    </div>
                </div>
                <div>
                    <h2 class="precio">$1,300.00</span>
                </div>
                <a href="php/paypal.php" class="btn-1">Comprar</a>
            </div>

            <div class="swiper-slide">
                <div class="icons">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                    <img src="#" alt="">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="titulodisco">History</h3>
                <div>
                    <p class="lista">Lista de canciones</p>
                </div>
                <div class="product-content">
                    <div class="product-txt">
                        <p> 1.The Way You Make Me Feel</p>
                        <p> 2.Black or White</p>
                        <p> 3.Rock with You</p>
                        <p> 4.She's Out of My Life</p>
                        <p> 5.Beat It</p>
                        <p> 6.Remember the Time</p>
                        <p> 7.Heal the World</p>
                        <p> 8.Stranger in Moscow</p>
                    </div>
                    <div class="product-img">
                        <img src="Imagenes/History.webp" alt="">
                    </div>
                </div>
                <div>
                    <h2 class="precio">$1,600.00</span>
                </div>
                <a href="php/paypal.php" class="btn-1">Comprar</a>
            </div>

            <div class="swiper-slide">
                <div class="icons">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                    <img src="#" alt="">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="titulodisco">Got To Be There</h3>
                <div>
                    <p class="lista">Lista de canciones</p>
                </div>
                <div class="product-content">
                    <div class="product-txt">
                        <p> 1.Ain't No Sunshine</p>
                        <p> 2.I Wanna Be Where You Are</p>
                        <p> 3.In Our Small Way</p>
                        <p> 4.Got To Be There</p>
                        <p> 5.Rockin' Robin</p>
                        <p> 6.Wings Of My Love</p>
                        <p> 7.You've Got A Friend</p>
                    </div>
                    <div class="product-img">
                        <img src="Imagenes/Go to be there.webp" alt="">
                    </div>
                </div>
                <div>
                    <h2 class="precio">$1,500.00</span>
                </div>
                <a href="php/paypal.php" class="btn-1">Comprar</a>
            </div>

            <div class="swiper-slide">
                <div class="icons">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                    <img src="#" alt="">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="titulodisco">Ben</h3>
                <div>
                    <p class="lista">Lista de canciones</p>
                </div>
                <div class="product-content">
                    <div class="product-txt">
                        <p>1.Ben</p>
                        <p>2.Greatest Show On Earth</p>
                        <p> 3.People Make The World Go 'Round</p>
                        <p> 4.We've Got A Good Thing Going</p>
                        <p>5.Everybody's Somebody's Fool</p>
                        <p>6.My Girl</p>
                    </div>
                    <div class="product-img">
                        <img src="Imagenes/Ben.webp" alt="">
                    </div>
                </div>
                <div>
                    <h2 class="precio">$1,400.00</span>
                </div>
                <a href="php/paypal.php" class="btn-1">Comprar</a>
            </div>

            <div class="swiper-slide">
                <div class="icons">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                    <img src="#" alt="">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="titulodisco">Scream</h3>
                <div>
                    <p class="lista">Lista de canciones</p>
                </div>
                <div class="product-content">
                    <div class="product-txt">
                        <p> 1.Scream (Classic Club Mix)</p>
                        <p> 2.Scream (D.M. Extended R&B Mix)</p>
                        <p> 3.Scream (Pressurized Dub Pt. 1)</p>
                        <p> 4.Scream (Naughty Main Mix)</p>
                        <p> 5.Scream (Single Edit #2)</p>
                    </div>
                    <div class="product-img">
                        <img src="Imagenes/Scream.webp" alt="">
                    </div>
                </div>
                <div>
                    <h2 class="precio">$1,350.00</span>
                </div>
                <a href="php/paypal.php" class="btn-1">Comprar</a>
            </div>

            <div class="swiper-slide">
                <div class="icons">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                    <img src="#" alt="">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="titulodisco">billie jean</h3>
                <div>
                    <p class="lista">Lista de canciones</p>
                </div>
                <div class="product-content">
                    <div class="product-txt">
                        <p>Lista de temas</p>
                        <p> 1.It's the Falling in Love</p>
                        <p>2.Billie Jean</p>
                    </div>
                    <div class="product-img">
                        <img src="Imagenes/BillieJean.webp" alt="">
                    </div>
                </div>
                <div>
                    <h2 class="precio">$1,650.00</span>
                </div>
                <a href="php/paypal.php" class="btn-1">Comprar</a>
            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            loop: true,
            coverflowEffect: {
                depth: 500,
                modifer: 1,
                slidesShadows: true,
                rotate: 0,
                stretch: 0
            }
        })
    </script>
    <!-- Importación js -->
    <script src="app.js"></script>

    <div class="creditos">
        <h2>Programación web</h2>
        <p>Ago-Dic 2024</p>
    </div>

</body>

</html>