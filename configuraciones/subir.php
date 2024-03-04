<?php

include '../api-google/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=../credencial/registrospersonal-19cdd694db83.json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos de conexión a la base de datos (ajusta estos valores)
    $hostname = "localhost"; // Nombre del servidor de la base de datos
    $username = "root"; // Tu nombre de usuario de la base de datos
    $password = ""; // Tu contraseña de la base de datos
    $database = "db_globales"; // Nombre de la base de datos

    // Establecer la conexión
    $conexion = mysqli_connect($hostname, $username, $password, $database);

    // Verifica la conexión a la base de datos
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Verifica si la columna 'carpeta_drive_id' existe en la tabla 'registro_empleados'
    $verificarColumna = mysqli_query($conexion, "DESCRIBE registro_empleados carpeta_drive_id");

    if (mysqli_num_rows($verificarColumna) == 0) {
        // Si la columna no existe, agrégala a la tabla
        $agregarColumna = mysqli_query($conexion, "ALTER TABLE registro_empleados ADD carpeta_drive_id VARCHAR(255)");
        
        if ($agregarColumna) {
            echo "Columna 'carpeta_drive_id' agregada correctamente a la tabla.<br>";
        } else {
            echo "Error al agregar la columna: " . mysqli_error($conexion) . "<br>";
        }
    }

    // Initialize $rutaDestino
    $rutaDestino = '';

    // Check if files are uploaded
    if (isset($_FILES['archivos']) && is_array($_FILES['archivos']['name'])) {
        // Loop through uploaded files
        for ($i = 0; $i < count($_FILES['archivos']['name']); $i++) {
            $archivoTemp = $_FILES['archivos']['tmp_name'][$i];
            $nombreArchivo = $_FILES['archivos']['name'][$i];

            // Obtener datos del formulario
            $nombreCompleto = $_POST['nombre_completo'];
            $fechaNacimiento = $_POST['fecha_nacimiento'];
            $direccion = $_POST['direccion'];
            $fechaIngreso = $_POST['fecha_ingreso'];
            $estatus = $_POST['estatus'];
            $telefonoCelular = $_POST['telefono_celular'];
            $correoElectronico = $_POST['correo_electronico'];
            $nombreContacto = $_POST['nombre_contacto'];
            $telefonoContacto = $_POST['telefono_contacto'];
            $sueldoQuincenal = $_POST['sueldo_quincenal'];
            $horarioTrabajo = $_POST['horario_trabajo'];
            $numeroSeguroSocial = $_POST['numero_seguridad_social'];
            $fechaAltaSeguroSocial = $_POST['fecha_alta_seguridad_social'];
            $redesSociales = $_POST['redes_sociales'];
            $areaAsignada = $_POST['area'];

            // Obtener el nombre completo y la fecha de ingreso para crear la carpeta
            $carpetaNombre = str_replace(' ', '_', $nombreCompleto) . '_' . str_replace('-', '', $fechaIngreso);
            $carpetaRaizId = '1PLRfMlA3ZRrEGw9Lp1ee4FGYezRGE113';

            // Call the crearCarpetaSiNoExiste function to create the folder if it doesn't exist
            $carpetaId = crearCarpetaSiNoExiste($carpetaNombre, $carpetaRaizId);

            if ($carpetaId) {
                // Upload the file to Google Drive
                if (subirArchivoAGoogleDrive($archivoTemp, $nombreArchivo, $carpetaId)) {
                    // File uploaded successfully
                    $carpetaDrive = 'https://drive.google.com/drive/folders/' . $carpetaId;
                    $rutaDestino = $carpetaDrive;
                    echo "El archivo '$nombreArchivo' se subió correctamente.<br>";
                } else {
                    // Handle any errors related to file upload
                    echo "Error al subir el archivo '$nombreArchivo'.<br>";
                }
            } else {
                // Handle the case when folder creation fails
                echo "Error al crear la carpeta en Google Drive.<br>";
            }

            // Insertar los datos en la base de datos (ajusta esta consulta según tu estructura de base de datos)
            $sql = "INSERT INTO registro_empleados (nombre_completo, fecha_nacimiento, direccion, fecha_ingreso, estatus, telefono_celular, correo_electronico, nombre_contacto, telefono_contacto, sueldo_quincenal, horario_trabajo, numero_seguridad_social, fecha_alta_seguro_social, redes_sociales, area_asignada, archivos, carpeta_drive_id) VALUES ('$nombreCompleto', '$fechaNacimiento', '$direccion', '$fechaIngreso', '$estatus', '$telefonoCelular', '$correoElectronico', '$nombreContacto', '$telefonoContacto', '$sueldoQuincenal', '$horarioTrabajo', '$numeroSeguroSocial', '$fechaAltaSeguroSocial', '$redesSociales', '$areaAsignada', '$rutaDestino', '$carpetaId')";

            // Ejecutar la consulta SQL
            if (mysqli_query($conexion, $sql)) {
                header("Location: ../secciones/registro.php");
            } else {
                echo "Error al insertar datos: " . mysqli_error($conexion);
            }
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conexion);
    } else {
        // Handle the case when no files are uploaded or an error occurred during upload
        echo "No se han subido archivos o se produjo un error durante la subida.<br>";
    }
}

// Función para crear una carpeta en Google Drive si no existe y obtener su ID
function crearCarpetaSiNoExiste($nombreCarpeta, $carpetaRaizId) {
    // Inicializa el cliente de Google API para Drive
    $cliente = new Google_Client();
    $cliente->setAuthConfig('../credencial/registrospersonal-19cdd694db83.json');
    $cliente->addScope(Google_Service_Drive::DRIVE);

    // Crea una instancia del servicio de Google Drive
    $servicioDrive = new Google_Service_Drive($cliente);

    try {
        // Verifica si la carpeta ya existe en la raíz de Google Drive
        $carpetaExistente = $servicioDrive->files->listFiles([
            'q' => "name='$nombreCarpeta' and mimeType='application/vnd.google-apps.folder' and '$carpetaRaizId' in parents",
        ]);

        if (count($carpetaExistente->getFiles()) > 0) {
            // La carpeta ya existe en la raíz, obtén su ID
            $carpetaId = $carpetaExistente->getFiles()[0]->getId();
        } else {
            // La carpeta no existe en la raíz, créala en la raíz
            $carpeta = new Google_Service_Drive_DriveFile([
                'name' => $nombreCarpeta,
                'mimeType' => 'application/vnd.google-apps.folder',
                'parents' => [$carpetaRaizId],
            ]);
            $carpetaCreada = $servicioDrive->files->create($carpeta, ['fields' => 'id']);
            $carpetaId = $carpetaCreada->id;
        }

        return $carpetaId;
    } catch (Exception $e) {
        // Manejo de errores
        return null;
    }
}

// Función para subir un archivo a Google Drive
function subirArchivoAGoogleDrive($archivoTemp, $nombreArchivo, $carpetaId) {
    // Check if the file path is empty
    if (empty($archivoTemp)) {
        // Handle the case when the file path is empty
        return false;
    }

    // Initialize the Google Drive API client
    $cliente = new Google_Client();
    $cliente->setAuthConfig('../credencial/registrospersonal-19cdd694db83.json');
    $cliente->addScope(Google_Service_Drive::DRIVE);

    // Create an instance of the Google Drive service
    $servicioDrive = new Google_Service_Drive($cliente);

    try {
        // Create a file object
        $archivo = new Google_Service_Drive_DriveFile([
            'name' => $nombreArchivo,
            'parents' => [$carpetaId],
        ]);

        // Upload the file to Drive
        $servicioDrive->files->create($archivo, [
            'data' => file_get_contents($archivoTemp),
            'mimeType' => mime_content_type($archivoTemp),
            'uploadType' => 'multipart',
        ]);

        return true; // Successfully uploaded the file
    } catch (Exception $e) {
        // Handle any errors related to file upload
        return false;
    }
}
?>
