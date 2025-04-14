<!-- ingresar.php -->
<?php
session_start();
$email = $_POST['email'];
$contraseña = $_POST['contraseña'];

// Ejemplo de validación (puedes conectar con tu base de datos para verificar las credenciales)
$admin_email = "admin@carros.com";
$admin_password = "admin123";

// Simulación de autenticación (ajustar a tu base de datos real)
if ($email == $admin_email && $contraseña == $admin_password) {
    $_SESSION['role'] = 'admin';  // Asignar rol de administrador
    header('Location: admin.php'); // Redirigir al panel de administración
    exit();
} else {
    // Validación de usuario común
    // Aquí puedes verificar las credenciales en tu base de datos
    $_SESSION['role'] = 'user';  // Asignar rol de usuario
    header('Location: vehiculos.php'); // Redirigir a la página de vehículos
    exit();
}
?>
