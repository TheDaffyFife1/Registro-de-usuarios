<?php
$hostname = "localhost"; // Nombre del servidor de la base de datos
$username = "root"; // Tu nombre de usuario de la base de datos
$password = ""; // Tu contraseña de la base de datos
$database = "db_globales"; // Nombre de la base de datos

// Establecer la conexión
$conexion = mysqli_connect($hostname, $username, $password, $database);

// Verificar la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>