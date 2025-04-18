<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Llamar al backend para verificar las credenciales
    $url = "http://localhost:3001/api/usuarios/login"; // Endpoint del backend
    $data = json_encode(array("email" => $email, "contraseña" => $password));

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => $data,
        ),
    );
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        die('Error al conectar con el backend');
    }

    $response_data = json_decode($response, true);

    if ($response_data['message'] == 'Login exitoso') {
        // Guardamos los datos de la sesión
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $response_data['role']; // Almacenamos el rol en la sesión

        // Redirigir al perfil si es un usuario, o al admin si es el administrador
        if ($_SESSION['role'] == 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: perfil.php');
        }
        exit;
    } else {
        $error_message = $response_data['message'];  // Mostrar el mensaje de error si las credenciales son incorrectas
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <header>
        <h1>Iniciar Sesión</h1>
    </header>

    <section>
        <form method="POST" action="login.php">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Iniciar Sesión</button>
        </form>

        <?php if (isset($error_message)): ?>
            <p style="color:red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </section>

</body>
</html>
