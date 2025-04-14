<?php
require_once 'UsuarioAPI.php';
session_start();
$api = new UsuarioAPI();

$id = $_SESSION['usuario'] ?? null;
if (!$id) {
  echo "Sesión no iniciada.";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $resp = $api->actualizarUsuario($id, $_POST['email'], $_POST['nombre'], $_POST['telefono']);
  echo "<pre>" . print_r($resp, true) . "</pre>";
}
$usuario = $api->obtenerUsuarioPorId($id);
?>
<a href="logout.php">Cerrar sesión</a>
<form method="POST">
  Email: <input type="email" name="email" value="<?= $usuario['body']['email'] ?? '' ?>"><br>
  Nombre: <input type="text" name="nombre" value="<?= $usuario['body']['nombre'] ?? '' ?>"><br>
  Teléfono: <input type="text" name="telefono" value="<?= $usuario['body']['telefono'] ?? '' ?>"><br>
  <button type="submit">Actualizar</button>
</form>
