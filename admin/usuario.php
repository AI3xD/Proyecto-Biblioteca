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
    <title>Biblioteka Admin - Gestión de Usuarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Lilita+One&display=swap" rel="stylesheet">
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

        .section-title {
            font-family: 'Lilita One', cursive;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: var(--negro);
        }

        .btn {
            display: inline-block;
            background-color: var(--rosa);
            color: var(--blanco);
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #d62e4a;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--blanco);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .users-table th,
        .users-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gris);
        }

        .users-table th {
            background-color: var(--verde);
            color: var(--blanco);
            font-weight: 600;
        }

        .users-table tr:last-child td {
            border-bottom: none;
        }

        .action-btn {
            padding: 0.25rem 0.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-btn {
            background-color: var(--azul);
            color: var(--blanco);
        }

        .delete-btn {
            background-color: var(--rosa);
            color: var(--blanco);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: var(--blanco);
            margin: 15% auto;
            padding: 2rem;
            border-radius: 8px;
            width: 50%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: var(--negro);
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--gris);
            border-radius: 4px;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }

            .nav {
                margin-top: 1rem;
            }

            .modal-content {
                width: 90%;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

    <main class="container">
        <h2 class="section-title">Gestión de Usuarios</h2>
        <button class="btn" onclick="openModal()">Agregar Usuario</button>

        <table class="users-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                <!-- Los usuarios se cargarán aquí dinámicamente -->
            </tbody>
        </table>
    </main>

    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle">Agregar Usuario</h3>
            <form id="userForm">
                <input type="hidden" id="userId">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select id="rol" name="rol" required>
                        <option value="usuario">Usuario</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>
                <button type="submit" class="btn">Guardar</button>
            </form>
        </div>
    </div>

    <script>
        // Datos de ejemplo (en una aplicación real, estos vendrían de una base de datos)
        let users = [
            { id: 1, nombre: 'Juan Pérez', email: 'juan@example.com', rol: 'usuario' },
            { id: 2, nombre: 'María García', email: 'maria@example.com', rol: 'administrador' }
        ];

        function loadUsers() {
            const tbody = document.getElementById('usersTableBody');
            tbody.innerHTML = '';
            users.forEach(user => {
                tbody.innerHTML += `
                    <tr>
                        <td>${user.nombre}</td>
                        <td>${user.email}</td>
                        <td>${user.rol}</td>
                        <td>
                            <button class="action-btn edit-btn" onclick="editUser(${user.id})">Editar</button>
                            <button class="action-btn delete-btn" onclick="deleteUser(${user.id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
        }

        function openModal(userId = null) {
            const modal = document.getElementById('userModal');
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('userForm');
            
            if (userId) {
                title.textContent = 'Editar Usuario';
                const user = users.find(u => u.id === userId);
                document.getElementById('userId').value = user.id;
                document.getElementById('nombre').value = user.nombre;
                document.getElementById('email').value = user.email;
                document.getElementById('rol').value = user.rol;
            } else {
                title.textContent = 'Agregar Usuario';
                form.reset();
                document.getElementById('userId').value = '';
            }
            
            modal.style.display = 'block';
        }

        function closeModal() {
            document.getElementById('userModal').style.display = 'none';
        }

        function editUser(id) {
            openModal(id);
        }

        function deleteUser(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                users = users.filter(user => user.id !== id);
                loadUsers();
            }
        }

        document.getElementById('userForm').onsubmit = function(e) {
            e.preventDefault();
            const userId = document.getElementById('userId').value;
            const nombre = document.getElementById('nombre').value;
            const email = document.getElementById('email').value;
            const rol = document.getElementById('rol').value;

            if (userId) {
                // Editar usuario existente
                const index = users.findIndex(u => u.id == userId);
                users[index] = { id: parseInt(userId), nombre, email, rol };
            } else {
                // Agregar nuevo usuario
                const newId = users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 1;
                users.push({ id: newId, nombre, email, rol });
            }

            loadUsers();
            closeModal();
        };

        // Cargar usuarios al iniciar la página
        loadUsers();
    </script>
</body>
</html>