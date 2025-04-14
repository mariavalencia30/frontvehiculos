<?php
require_once 'UsuarioAPI.php';
$api = new UsuarioAPI();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $resp = $api->eliminarUsuario($_POST['id']);
  echo "<pre>" . print_r($resp, true) . "</pre>";
}
?>
<form method="POST">
  ID del usuario a eliminar: <input type="text" name="id"><br>
  <button type="submit">Eliminar</button>
</form>
