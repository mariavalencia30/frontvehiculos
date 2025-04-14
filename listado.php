<?php
require_once 'UsuarioAPI.php';
$api = new UsuarioAPI();
$resp = $api->obtenerTodos();
echo "<pre>" . print_r($resp, true) . "</pre>";
?>
