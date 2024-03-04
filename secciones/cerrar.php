<?php
session_start();

// Verificar si la sesión está activa y la cookie está configurada
if (!isset($_SESSION['usuario']) || !isset($_COOKIE['sesion_activa'])) {
    header("Location: ../index.php");
    exit(); // Asegura que el script se detenga después de la redirección
}

?>

<?php 
session_start();
session_destroy();
header('Location:../index.php');

?>
