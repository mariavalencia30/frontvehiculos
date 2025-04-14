<?php
require_once 'UsuarioAPI.php';
session_start();
$api = new UsuarioAPI();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // Enviar las credenciales al backend
    $resp = $api->login($email, $contrasena);

    if ($resp['status'] === 200) {
        // Si el login es exitoso, se establece la sesión
        $_SESSION['token'] = $resp['body']['token'];  // Guardar el token JWT

        // Redirigir según el tipo de usuario
        if ($email === 'admisalecars@car.com') {
            $_SESSION['admin'] = true;  // Establecer la sesión de administrador
            header('Location: admin.php');
        } else {
            $_SESSION['usuario'] = $resp['body']['id'];  // Establecer la sesión de usuario
            header('Location: perfil.php');
        }
        exit;
    } else {
        echo "<p>Credenciales incorrectas</p>";  // Mensaje de error si la autenticación falla
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Venta de Carros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
        <p>¿No tienes cuenta? <a href="registrar.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
