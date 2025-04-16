<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    // Llamar al backend para registrar el nuevo usuario
    $url = "http://localhost:3001/api/usuarios/register"; // Endpoint del backend
    $data = json_encode(array("email" => $email, "nombre" => $nombre, "telefono" => $telefono, "contraseña" => $password));

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

    if ($response_data['message'] == 'Usuario registrado exitosamente') {
        header('Location: login.php');
        exit;
    } else {
        $error_message = $response_data['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>

    <header>
        <h1>Registrarse</h1>
    </header>

    <section>
        <form method="POST" action="registro.php">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Registrarse</button>
        </form>

        <?php if (isset($error_message)): ?>
            <p style="color:red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </section>

</body>
</html>
