<!-- ingresar.php -->
<?php
session_start();

// Datos del administrador (credenciales fijas)
$admin_email = "admisalecars@car.com";
$admin_password = "thebestcars";

// Obtener los datos del formulario
$email = $_POST['email'];
$contraseña = $_POST['contraseña'];

// Validación para el administrador
if ($email == $admin_email && $contraseña == $admin_password) {
    $_SESSION['role'] = 'admin';  // Asignar rol de administrador
    header('Location: admin.php'); // Redirigir al panel de administración
    exit();
} else {
    // Aquí iría la validación en la base de datos para los usuarios
    $_SESSION['role'] = 'user';  // Asignar rol de usuario
    header('Location: vehiculos.php'); // Redirigir a la página de vehículos
    exit();
}
?>
