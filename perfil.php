<?php
session_start();

// Verificamos que el usuario esté logueado
if (!isset($_SESSION['email']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit;
}

$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];  // Asegúrate de que el ID del usuario está guardado en la sesión

// Si el formulario es enviado para actualizar el perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'update') {
        // Obtener los datos del formulario
        $new_email = $_POST['new_email'];
        $new_nombre = $_POST['new_nombre'];
        $new_telefono = $_POST['new_telefono'];
        $new_password = $_POST['new_password'];  // Opcional, solo se cambia si es proporcionada

        // Hacer una solicitud PUT al backend para actualizar el perfil
        $url = "http://localhost:3001/api/usuarios/{$user_id}";  // PUT endpoint de actualización
        $data = json_encode(array(
            "email" => $new_email,
            "nombre" => $new_nombre,
            "telefono" => $new_telefono,
            "contraseña" => $new_password
        ));

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'PUT',
                'content' => $data,
            ),
        );
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $response_data = json_decode($response, true);

        if ($response_data) {
            $message = $response_data['message'];
        } else {
            $message = "Hubo un error al procesar la solicitud.";
        }
    }

    // Logout
    if ($_POST['action'] == 'logout') {
        // Llamamos al endpoint de logout
        $url = "http://localhost:3001/api/usuarios/logout";
        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
            ),
        );
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        // Eliminar los datos de la sesión
        session_destroy();
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
</head>
<body>

    <header>
        <h1>Bienvenido al Perfil de Usuario, <?php echo $email; ?></h1>
    </header>

    <section>
        <h2>Actualizar Perfil</h2>

        <!-- Mostrar mensaje de éxito o error -->
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

        <form method="POST" action="perfil.php">
            <input type="hidden" name="action" value="update">
            <input type="text" name="new_email" placeholder="Nuevo Correo Electrónico" required>
            <input type="text" name="new_nombre" placeholder="Nuevo Nombre" required>
            <input type="text" name="new_telefono" placeholder="Nuevo Teléfono" required>
            <input type="password" name="new_password" placeholder="Nueva Contraseña (Opcional)">
            <button type="submit">Actualizar Perfil</button>
        </form>
    </section>

    <!-- Cerrar Sesión -->
    <section>
        <h2>Cerrar sesión</h2>
        <form method="POST" action="perfil.php">
            <input type="hidden" name="action" value="logout">
            <button type="submit">Cerrar Sesión</button>
        </form>
    </section>

    <footer>
        <a href="logout.php">Cerrar sesión</a>
    </footer>

</body>
</html>
