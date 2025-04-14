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

<h3>Registrar Usuario</h3>
<form method="POST">
  <input type="hidden" name="crear" value="1">
  Email: <input type="email" name="email"><br>
  Nombre: <input type="text" name="nombre"><br>
  Teléfono: <input type="text" name="telefono"><br>
  Contraseña: <input type="password" name="contrasena"><br>
  <button type="submit">Registrar</button>
</form>

<h3>Actualizar Usuario</h3>
<form method="POST">
  <input type="hidden" name="actualizar" value="1">
  ID: <input type="text" name="id"><br>
  Email: <input type="email" name="email"><br>
  Nombre: <input type="text" name="nombre"><br>
  Teléfono: <input type="text" name="telefono"><br>
  <button type="submit">Actualizar</button>
</form>

<h3>Eliminar Usuario</h3>
<form method="POST">
  <input type="hidden" name="eliminar" value="1">
  ID: <input type="text" name="id"><br>
  <button type="submit">Eliminar</button>
</form>

<h3>Lista de Usuarios</h3>
<pre><?php print_r($usuarios); ?></pre>
