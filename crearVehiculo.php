<!-- crearVehiculo.php -->
<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: index.html'); // Redirige a login si no es administrador
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Vehículo</title>
</head>
<body>
    <h1>Crear Vehículo</h1>
    <form action="procesar.php" method="POST">
        <label for="marca">Marca:</label>
        <input type="text" name="marca" id="marca" required><br><br>
        
        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" id="modelo" required><br><br>
        
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" required><br><br>
        
        <button type="submit">Crear Vehículo</button>
    </form>
</body>
</html>
