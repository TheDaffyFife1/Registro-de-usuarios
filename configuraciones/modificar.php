<?php

include '../api-google/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=../credencial/registrospersonal-19cdd694db83.json');

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_registro = $_POST["id_registro"];
    // Rest of the code to retrieve and validate form data

    $nombre_completo = $_POST["nombre_completo"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $direccion = $_POST["direccion"];
    $fecha_ingreso = $_POST["fecha_ingreso"];
    $estatus = $_POST["estatus"];
    $telefono_celular = $_POST["telefono_celular"];
    $correo_electronico = $_POST["correo_electronico"];
    $nombre_contacto = $_POST["nombre_contacto"];
    $telefono_contacto = $_POST["telefono_contacto"];
    $sueldo_quincenal = $_POST["sueldo_quincenal"];
    $horario_trabajo = $_POST["horario_trabajo"];
    $numero_seguridad_social = $_POST["numero_seguridad_social"];
    $fecha_alta_seguro_social = $_POST["fecha_alta_seguro_social"];
    $redes_sociales = $_POST["redes_sociales"];
    $area_asignada = $_POST["area_asignada"];

    if (empty($fecha_nacimiento)) {
        // Handle the error, you can display a message to the user or provide a default date
        echo "Fecha de nacimiento es un campo requerido.";
    } else {
        // SQL query to update the existing record
        $query = "UPDATE registro_empleados SET 
        nombre_completo = ?, 
        fecha_nacimiento = ?, 
        direccion = ?, 
        fecha_ingreso = ?, 
        estatus = ?, 
        telefono_celular = ?, 
        correo_electronico = ?, 
        nombre_contacto = ?, 
        telefono_contacto = ?, 
        sueldo_quincenal = ?, 
        horario_trabajo = ?, 
        numero_seguridad_social = ?, 
        fecha_alta_seguro_social = ?, 
        redes_sociales = ?, 
        area_asignada = ? 
        WHERE id = ?";

// Prepare the query
$stmt = $conexion->prepare($query);

// Bind the parameters and execute the query
$stmt->bind_param("sssssssssssssssi", 
    $nombre_completo, 
    $fecha_nacimiento, 
    $direccion, 
    $fecha_ingreso, 
    $estatus, 
    $telefono_celular, 
    $correo_electronico, 
    $nombre_contacto, 
    $telefono_contacto, 
    $sueldo_quincenal, 
    $horario_trabajo, 
    $numero_seguridad_social, 
    $fecha_alta_seguro_social, 
    $redes_sociales, 
    $area_asignada, 
    $id_registro
);

if ($stmt->execute()) {
    // Update success, redirect or display a confirmation message
    header("Location: ../secciones/historial.php"); // Redirect to the record list after editing
    exit();
} else {
    // Update error, handle the error appropriately
    echo "Error in update.";
}

    }
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>
