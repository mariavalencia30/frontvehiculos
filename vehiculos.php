<!-- vehiculos.php -->
<?php
session_start();
if ($_SESSION['role'] != 'user') {
    header('Location: index.html'); // Redirige a login si no es un usuario
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehículos Disponibles</title>
</head>
<body>
    <h1>Vehículos Disponibles</h1>
    <ul>
        <li>Vehículo 1</li>
        <li>Vehículo 2</li>
        <li>Vehículo 3</li>
    </ul>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
