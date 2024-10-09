<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'Admin') {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka Admin - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Lilita+One&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --verde: #4CB8B3;
            --rosa: #F53756;
            --amarillo: #fdda00;
            --morado: #752F97;
            --negro: #000000;
            --blanco: #FFFFFF;
            --gris: #f2f2f2;
            --azul: rgb(78, 155, 232);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--gris);
            color: var(--negro);
            line-height: 1.6;
        }

        .header {
            background-color: var(--verde);
            color: var(--blanco);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-family: 'Lilita One', cursive;
            font-size: 2rem;
        }

        .nav {
            display: flex;
            gap: 1rem;
        }

        .nav-link {
            color: var(--blanco);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s ease;
        }

        .nav-link:hover {
            opacity: 0.8;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .dashboard-title {
            font-family: 'Lilita One', cursive;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: var(--negro);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .dashboard-card {
            background-color: var(--blanco);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .dashboard-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .dashboard-card-icon {
            background-color: var(--verde);
            color: var(--blanco);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 1rem;
            text-decoration: none;
        }

        .dashboard-card h3 {
            font-family: 'Lilita One', cursive;
            font-size: 1.5rem;
            color: var(--verde);
        }

        .dashboard-card p {
            color: var(--negro);
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }

            .nav {
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Biblioteka Admin</h1>
        <nav class="nav">
            <a href="#" class="nav-link">Dashboard</a>
            <a href="libros.php" class="nav-link">Libros</a>
            <a href="usuarios.php" class="nav-link">Usuarios</a>
            <a href="reportes.php" class="nav-link">Reportes</a>
        </nav>
    </header>

    <main class="container">
        <h2 class="dashboard-title">Dashboard</h2>
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <a href="libros.php" class="dashboard-card-icon">
                        <i data-lucide="book-open"></i>
                    </a>
                    <h3>Ver Libros</h3>
                </div>
                <p>Gestionar ver libros</p>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <a href="usuario.php" class="dashboard-card-icon">
                        <i data-lucide="users"></i>
                    </a>
                    <h3>Ver Usuarios</h3>
                </div>
                <p>Gestionar ver usuarios</p>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <a href="reportes.php" class="dashboard-card-icon">
                        <i data-lucide="file-text"></i>
                    </a>
                    <h3>Generar Reporte</h3>
                </div>
                <p>Gestionar generar reporte</p>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <a href="cerrar.php" class="dashboard-card-icon" id="cerrarSesion">
                        <i data-lucide="log-out"></i>
                    </a>
                    <h3>Cerrar Sesión</h3>
                </div>
                <p>Gestionar cerrar sesión</p>
            </div>
        </div>
    </main>

    <script>
        // Inicializar los iconos de Lucide
        lucide.createIcons();
    </script>
</body>
</html>