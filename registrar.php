<?php
require_once 'UsuarioAPI.php';
$api = new UsuarioAPI();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $resp = $api->registrarUsuario($_POST['email'], $_POST['nombre'], $_POST['telefono'], $_POST['contrasena']);
  echo "<pre>" . print_r($resp, true) . "</pre>";
}
?>
<form method="POST">
  Email: <input type="email" name="email"><br>
  Nombre: <input type="text" name="nombre"><br>
  Teléfono: <input type="text" name="telefono"><br>
  Contraseña: <input type="password" name="contrasena"><br>
  <button type="submit">Registrar</button>
</form>
