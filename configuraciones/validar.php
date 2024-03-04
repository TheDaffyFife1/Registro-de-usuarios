<?php
// Archivo de conexión a la base de datos
require 'conexion.php';

session_start();


// Obtener los datos del formulario
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Preparar la consulta SQL
$query = "SELECT * FROM registro_login WHERE usuario='$usuario' AND contrasena='$contrasena'";

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

// Verificar el resultado
if (mysqli_num_rows($result) == 1) {
    $_SESSION['usuario'] = $usuario; // Guardar el email del usuario en la sesión
    setcookie("sesion_activa", "true", time() + 3600, "/"); // Configurar una cookie con una hora de expiración

    header("Location: ../secciones/registro.php");
    // Puedes redirigir al usuario a una página de inicio, por ejemplo.
} else {
    header("Location: ../index.php?error=1");
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>


