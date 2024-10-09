<?php
session_start(); // Iniciar la sesión para verificar si el usuario ha iniciado sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Lilita+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Montserrat:ital,wght@0,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1, user-scalable=1">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/zub3tbp.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <div class="wrapper-nav">
                    <div class="logo">
                        <a href="#">Biblioteka</a>
                    </div>
                    <ul class="nav-links">
                        <li><a href="#">Inicio</a></li>
                        <li><a href="catalogo.php">Catálogo</a></li>
                        <!-- Verificar si la sesión está iniciada -->
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <div class="dropdown">
                                <a href="#" class="user-name"><?php echo $_SESSION['usuario']; ?> <i class="fas fa-chevron-down"></i></a>
                                <ul class="dropdown-menu ">
                                    <li><a href="#">Perfil</a></li>
                                    <li><a href="apis/logout.php">Cerrar sesión</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <li><a href="login.php">Iniciar sesión</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="separador"></div>

        <!-- Banner -->
        <section class="contenedor-banner">
            <div class="derecha">
                <div class="contenido-derecha">
                    <p>¿Quieres conocer más sobre nuestra biblioteca en línea?</p>
                    <a class="boton-conocer-mas" href="#info-seccion">Clic aquí para conocer más</a>
                </div>
            </div>
            <div class="izquierda">
                <div class="contenido-izquierda">
                    <!-- Imagen o contenido gráfico -->
                </div>
            </div>
        </section>

        <div class="espacio-2"></div>

        <!-- Contenedor principal para centrar el contenido -->
        <main class="main-wrapper">
            <div id="info-seccion" class="contenedor-info__usuario">
                <div class="info-box">
                    <h3>Navega nuestro catálogo</h3>
                    <p>Accede a una extensa colección de libros, artículos científicos, revistas y documentos académicos.</p>
                </div>
                <div class="info-box">
                    <h3>Accede a tus préstamos</h3>
                    <p>Consulta el estado de tus préstamos de libros físicos y digitales en cualquier momento.</p>
                </div>
                <div class="info-box">
                    <h3>Consulta nuestras recomendaciones</h3>
                    <p>Descubre libros que otros lectores han disfrutado. Te ofrecemos recomendaciones personalizadas basadas en tus intereses y hábitos de lectura.</p>
                </div>
                <div class="info-box">
                    <h3>Contáctanos</h3>
                    <p>¿Tienes preguntas sobre cómo utilizar nuestros servicios? Nuestro equipo de soporte está disponible para ayudarte a resolver cualquier duda o inconveniente.</p>
                </div>
            </div>
        </main>

        <footer>
            <div class="footer-content">
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                </div>
                <p>&copy; 2023 Todos los derechos reservados | <a href="#" class="footer-link">Biblioteka</a></p>
            </div>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script src="src/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paper.js/0.11.3/paper-full.min.js"></script>
</body>
</html>
