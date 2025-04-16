<?php
session_start();

// Verificamos que el usuario esté logueado y sea administrador
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

$email = $_SESSION['email'];

// Función para obtener todos los usuarios
function getAllUsers() {
    $url = "http://localhost:3001/api/usuarios"; // Endpoint de obtener todos los usuarios
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Si el formulario de registro es enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'register') {
        // Registro de un nuevo usuario
        $email = $_POST['email'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $password = $_POST['password'];

        // Llamar al backend para registrar un nuevo usuario
        $url = "http://localhost:3001/api/usuarios/register";
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
        $response_data = json_decode($response, true);
        $message = $response_data['message'];
    }

    // Para actualizar o eliminar un usuario (acción)
    if ($_POST['action'] == 'update' || $_POST['action'] == 'delete') {
        // Obtenemos el id del usuario desde el formulario
        $user_id = $_POST['user_id'];

        if ($_POST['action'] == 'update') {
            $new_email = $_POST['new_email'];
            $new_nombre = $_POST['new_nombre'];
            $new_telefono = $_POST['new_telefono'];
            $new_password = $_POST['new_password']; // Agregado el campo de contraseña

            // Corregimos la llamada PUT al backend para incluir la contraseña
            $url = "http://localhost:3001/api/usuarios/{$user_id}"; // PUT endpoint
            $data = json_encode(array(
                "email" => $new_email,
                "nombre" => $new_nombre,
                "telefono" => $new_telefono,
                "contraseña" => $new_password // Incluimos la contraseña en el body
            ));

            // Realizar la solicitud PUT con los datos del usuario
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
            $message = $response_data['message'];
        }

        if ($_POST['action'] == 'delete') {
            $url = "http://localhost:3001/api/usuarios/{$user_id}"; // DELETE endpoint
            $options = array(
                'http' => array(
                    'method' => 'DELETE',
                ),
            );
            $context = stream_context_create($options);
            file_get_contents($url, false, $context);
            $message = "Usuario eliminado correctamente!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
</head>
<body>

    <header>
        <h1>Bienvenido al Panel de Administración, <?php echo $email; ?></h1>
    </header>

    <section>
        <h2>Registrar Usuario</h2>
        <form method="POST" action="admin.php">
            <input type="hidden" name="action" value="register">
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrar</button>
        </form>
    </section>

    <section>
        <h2>Actualizar o Eliminar Usuario</h2>
        <form method="POST" action="admin.php">
            <input type="hidden" name="action" value="update">
            <label for="user_id">ID del Usuario:</label>
            <input type="number" name="user_id" placeholder="ID del usuario" required>
            <input type="text" name="new_email" placeholder="Nuevo Correo Electrónico">
            <input type="text" name="new_nombre" placeholder="Nuevo Nombre">
            <input type="text" name="new_telefono" placeholder="Nuevo Teléfono">
            <input type="password" name="new_password" placeholder="Nueva Contraseña"> <!-- Campo de contraseña -->
            <button type="submit">Actualizar</button>
        </form>

        <form method="POST" action="admin.php">
            <input type="hidden" name="action" value="delete">
            <label for="user_id">ID del Usuario a Eliminar:</label>
            <input type="number" name="user_id" placeholder="ID del usuario" required>
            <button type="submit">Eliminar</button>
        </form>
    </section>

    <section>
        <h2>Usuarios Registrados</h2>
        <?php
        // Obtener todos los usuarios
        $users = getAllUsers();
        if ($users) {
            echo "<ul>";
            foreach ($users as $user) {
                echo "<li>";
                echo "ID: " . $user['id'] . " | Email: " . $user['email'] . " | Nombre: " . $user['nombre'] . " | Teléfono: " . $user['telefono'];
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "No hay usuarios registrados.";
        }
        ?>
    </section>

    <footer>
        <a href="logout.php">Cerrar sesión</a>
    </footer>

</body>
</html>
