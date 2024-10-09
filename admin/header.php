<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Lilita+One&display=swap" rel="stylesheet">
    <style>
        /* Estilos básicos inline para simplificar */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .header {
            background-color: #4CB8B3;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-family: 'Lilita One', cursive;
            margin: 0;
        }
        .nav-button {
            color: var(--blanco);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s ease;
            margin-left: 1rem;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Biblioteka Admin</h1>
        <nav>
            <a href="index.php" class="nav-button">Dashboard</a>
            <a href="libros.php" class="nav-button">Libros</a>
            <a href="usuario.php" class="nav-button">Usuarios</a>
            <a href="reportes.php" class="nav-button">Reportes</a>
            <a href="cerrar.php" class="nav-button">Cerrar sesión</a>
        </nav>
    </header>
    <div class="container"></div>