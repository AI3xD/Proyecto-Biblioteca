<?php
session_start();
include 'db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buscar al usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($password, $user['clave'])) {
            $_SESSION['usuario'] = $user['usuario']; // Iniciar sesión
            echo "success"; // Login exitoso
        } else {
            echo "error"; // Contraseña incorrecta
        }
    } else {
        echo "error"; // Usuario no encontrado
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login and Sign Up</title>
  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="build/css/app.css">
</head>
<body>

<div id="back">
  <canvas id="canvas" class="canvas-back"></canvas>
  <div class="backRight"></div>
  <div class="backLeft"></div>
</div>

<div id="slideBox">
  <div class="topLayer">
    <div class="left">
      <div class="content">
        <h2>Sign Up</h2>
       <form id="form-signup" method="post">
    <div class="form-element form-stack">
        <label for="email-signup" class="form-label">Email</label>
        <input id="email-signup" type="text" name="email" required>
    </div>
    <div class="form-element form-stack">
        <label for="username-signup" class="form-label">Username</label>
        <input id="username-signup" type="text" name="username" required>
    </div>
    <div class="form-element form-stack">
        <label for="password-signup" class="form-label">Password</label>
        <input id="password-signup" type="password" name="password" required>
    </div>
    <div class="form-element form-checkbox">
        <input id="confirm-terms" type="checkbox" name="confirm" value="yes" class="checkbox" required>
        <label for="confirm-terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
    </div>
    <div class="form-element form-submit">
        <button id="signUp" class="signup" type="submit" name="signup">Sign up</button>
        <button id="goLeft" class="signup off">Log In</button>
    </div>
</form>
      </div>
    </div>
    <div class="right">
      <div class="content">
        <h2>Login</h2>
        <form id="form-login" method="post" onsubmit="return false;">
          <div class="form-element form-stack">
            <label for="username-login" class="form-label">Username</label>
            <input id="username-login" type="text" name="username">
          </div>
          <div class="form-element form-stack">
            <label for="password-login" class="form-label">Password</label>
            <input id="password-login" type="password" name="password">
          </div>
          <div class="form-element form-submit">
            <button id="logIn" class="login" type="submit" name="login">Log In</button>
            <button id="goRight" class="login off" name="signup">Sign Up</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="src/js/animaciones.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/paper.js/0.11.3/paper-full.min.js"></script>
<script src="src/js/login.js"></script>
</body>
</html>