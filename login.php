<?php
require_once 'UsuarioAPI.php';
session_start();
$api = new UsuarioAPI();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $contrasena = $_POST['contrasena'];

  $resp = $api->login($email, $contrasena);

  if ($resp['status'] === 200) {
    if ($email === 'admisalecars@car.com' && $contrasena === 'thebestcars') {
      $_SESSION['admin'] = true;
      header('Location: admin.php');
    } else {
      $_SESSION['usuario'] = $resp['body']['id'];
      header('Location: perfil.php');
    }
    exit;
  } else {
    echo "<p>Credenciales incorrectas</p>";
  }
}
?>
<form method="POST">
  Email: <input type="email" name="email"><br>
  Contraseña: <input type="password" name="contrasena"><br>
  <button type="submit">Login</button>
</form>
