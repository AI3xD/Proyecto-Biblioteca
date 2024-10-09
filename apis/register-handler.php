<?php
include '../db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Verificar si el usuario o el correo ya existen
    $query = "SELECT * FROM usuarios WHERE correo = ? OR nombre = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['correo'] === $email) {
            echo "email_exists"; // El correo ya existe
        } elseif ($user['nombre'] === $username) {
            echo "username_exists"; // El nombre de usuario ya existe
        }
    } else {
        // Insertar nuevo usuario
        $query = "INSERT INTO usuarios (tipo_usuario, nombre, clave, estado, correo) VALUES ('Usuario', ?, ?, 1, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $password, $email);

        if ($stmt->execute()) {
            echo "success"; // Registro exitoso
        } else {
            echo "error"; // Error en el registro
        }
    }
}
?>