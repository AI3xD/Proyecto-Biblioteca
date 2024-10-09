<?php
session_start();
include '../db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el usuario existe
    $query = "SELECT * FROM usuarios WHERE nombre = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        $hashed_password = $user['clave'];

        // Verificar si la contraseña está encriptada (reconociendo los hash generados por password_hash)
        if (password_needs_rehash($hashed_password, PASSWORD_DEFAULT) || password_verify($password, $hashed_password)) {
            // Caso de contraseña encriptada
            session_regenerate_id(); // Regenerar el ID de sesión para mayor seguridad
            $_SESSION['usuario'] = $user['nombre']; // Almacenar el nombre de usuario en la sesión
            $_SESSION['tipo_usuario'] = $user['tipo_usuario']; // Almacenar el tipo de usuario

            if (strcasecmp($user['tipo_usuario'], 'admin') === 0) {
                echo "admin"; // Redirigir a la vista de admin
            } else {
                echo "user"; // Redirigir a la vista del usuario
            }

        } elseif ($password === $hashed_password) {
            // Caso de contraseña sin encriptar
            session_regenerate_id(); // Regenerar el ID de sesión para mayor seguridad
            $_SESSION['usuario'] = $user['nombre']; // Almacenar el nombre de usuario en la sesión
            $_SESSION['tipo_usuario'] = $user['tipo_usuario']; // Almacenar el tipo de usuario

            if (strcasecmp($user['tipo_usuario'], 'admin') === 0) {
                echo "admin"; // Redirigir a la vista de admin
            } else {
                echo "user"; // Redirigir a la vista del usuario
            }

        } else {
            echo "incorrect_password"; // Contraseña incorrecta
        }
    } else {
        echo "user_not_found"; // Usuario no encontrado
    }
}
