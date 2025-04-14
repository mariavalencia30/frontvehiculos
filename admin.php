<?php
require_once 'UsuarioAPI.php';
session_start();
$api = new UsuarioAPI();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>
<a href="logout.php">Cerrar sesión</a>
<h2>Panel del Administrador</h2>


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['crear'])) {
    $resp = $api->registrarUsuario($_POST['email'], $_POST['nombre'], $_POST['telefono'], $_POST['contrasena']);
  } elseif (isset($_POST['actualizar'])) {
    $resp = $api->actualizarUsuario($_POST['id'], $_POST['email'], $_POST['nombre'], $_POST['telefono']);
  } elseif (isset($_POST['eliminar'])) {
    $resp = $api->eliminarUsuario($_POST['id']);
  }
}

$usuarios = $api->obtenerTodos();
?>
<a href="logout.php">Cerrar sesión</a>
<h2>Panel del Administrador</h2>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Bienvenido al Panel de Administrador</h2>
        <nav>
            <ul>
                <li><a href="agregar-carro.php">Agregar Carro</a></li>
                <li><a href="gestionar-usuarios.php">Gestionar Usuarios</a></li>
                <li><a href="ventas.php">Ver Ventas</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
        <h3>Opciones de Administración</h3>
        <p>Aquí puedes agregar vehículos, gestionar usuarios y más.</p>
    </div>
</body>
</html>
