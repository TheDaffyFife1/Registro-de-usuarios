<?php
session_start();

// Verificar si la sesión está activa y la cookie está configurada
if (!isset($_SESSION['usuario']) || !isset($_COOKIE['sesion_activa'])) {
    header("Location: ../index.php");
    exit(); // Asegura que el script se detenga después de la redirección
}

?>
<?php
include "../templates/cabecera.php";

$host = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "db_globales";

$conn = new mysqli($host, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");

if (isset($_GET['id'])) {
    $id_registro = $_GET['id'];
    
    // Realiza una consulta SQL para obtener los datos del registro con el ID especificado
    $query = "SELECT * FROM registro_empleados WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_registro);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Rellena el formulario de edición con los datos del registro
        // Asegúrate de que los campos del formulario tengan los mismos nombres que las columnas en la base de datos
?>
<div id='formulario'>
<h1>Modificar Formulario de  Contratacion</h1>
        <form id="miFormulario" action="../configuraciones/modificar.php" method="post">
        <input type="hidden" id="id_registro" name="id_registro" value="<?php echo $id_registro; ?>">
            <<div class="form-group">
                <label for="estatus">Estatus:</label>
                <select id="estatus" name="estatus">
                    <option value="activo" <?php echo ($row['estatus'] == 'activo') ? 'selected' : ''; ?>>Activo</option>
                    <option value="inactivo" <?php echo ($row['estatus'] == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre_completo">Nombre Completo:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo $row['nombre_completo']; ?>" >
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $row['fecha_nacimiento']; ?>" ><br>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo $row['direccion']; ?>" ><br>
            </div>
            
            
            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $row['fecha_nacimiento']; ?>" ><br>
            </div>

            
            <div class="form-group">
                <label for="telefono_celular">Teléfono Celular:</label>
                <input type="tel" id="telefono_celular" name="telefono_celular" value="<?php echo $row['fecha_nacimiento']; ?>" ><br>
            </div>
            <div class="form-group">
                <label for="correo_electronico">Correo Electrónico:</label>
                <input type="email" id="correo_electronico" name="correo_electronico" value="<?php echo $row['correo_electronico']; ?>" ><br>
            </div>
            <div class="form-group">
                <label for="nombre_contacto">Nombre de Contacto:</label>
                <input type="text" id="nombre_contacto" name="nombre_contacto" value="<?php echo $row['nombre_contacto']; ?>" ><br>
            </div>
            <div class="form-group">
                <label for="telefono_contacto">Teléfono de Contacto:</label>
                <input type="tel" id="telefono_contacto" name="telefono_contacto" value="<?php echo $row['telefono_contacto']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="sueldo_quincenal">Sueldo Quincenal:</label>
                <input type="number" id="sueldo_quincenal" name="sueldo_quincenal" step="0.01"  value="<?php echo $row['sueldo_quincenal']; ?>" ><br>
            </div>
            <div class="form-group">
                <label for="horario_trabajo">Horario de Trabajo:</label>
                <input type="text" id="horario_trabajo" name="horario_trabajo" value="<?php echo $row['horario_trabajo']; ?>" ><br>
            </div>
            <div class="form-group">
                <label for="numero_seguridad_social">Número de Seguro Social:</label>
                <input type="text" id="numero_seguridad_social" name="numero_seguridad_social" value="<?php echo $row['numero_seguridad_social']; ?>" ><br>
            </div>
            <div class="form-group">
                <label for="fecha_alta_seguridad_social">Fecha de Alta en Seguro Social:</label>
                <input type="date" id="fecha_alta_seguro_social" name="fecha_alta_seguro_social" value="<?php echo $row['fecha_alta_seguro_social']; ?>"><br>

            </div>
            <div class="form-group">
                <label for="redes_sociales">Redes Sociales:</label>
                <input type="text" id="redes_sociales" name="redes_sociales" value="<?php echo $row['redes_sociales']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="area">Area asignada:</label>
                <select id="area" name="area_asignada">
                    <option value="Hercules 1" <?php echo ($row['area_asignada'] == 'Hercules 1') ? 'selected' : ''; ?>>Hercules 1</option>
                    <option value="Hercules 2" <?php echo ($row['area_asignada'] == 'Hercules 2') ? 'selected' : ''; ?>>Hercules 2</option>
                    <option value="Hercules 3" <?php echo ($row['area_asignada'] == 'Hercules 3') ? 'selected' : ''; ?>>Hercules 3</option>
                    <option value="Hercules 4" <?php echo ($row['area_asignada'] == 'Hercules 4') ? 'selected' : ''; ?>>Hercules 4</option>
                    <option value="Twitter" <?php echo ($row['area_asignada'] == 'Twitter') ? 'selected' : ''; ?>>Twitter</option>
                    <option value="Whatsaap Grupos" <?php echo ($row['area_asignada'] == 'Whatsaap Grupos') ? 'selected' : ''; ?>>Whatsaap Grupos</option>
                    <option value="Whatsaap Individual" <?php echo ($row['area_asignada'] == 'Whatsaap Individual') ? 'selected' : ''; ?>>Whatsaap Individual</option>
                    <option value="Facebook Cancun" <?php echo ($row['area_asignada'] == 'Facebook Cancun') ? 'selected' : ''; ?>>Facebook Cancun</option>
                    <option value="Facebook CDMX" <?php echo ($row['area_asignada'] == 'Facebook CDMX') ? 'selected' : ''; ?>>Facebook CDMX</option>
                    <option value="Periodicos" <?php echo ($row['area_asignada'] == 'Periodicos') ? 'selected' : ''; ?>>Periodicos</option>
                    <option value="Monitoreo" <?php echo ($row['area_asignada'] == 'Monitoreo') ? 'selected' : ''; ?>>Monitoreo</option>
                    <option value="Ventas" <?php echo ($row['area_asignada'] == 'Ventas') ? 'selected' : ''; ?>>Ventas</option>
                    <option value="Reportes" <?php echo ($row['area_asignada'] == 'Reportes') ? 'selected' : ''; ?>>Reportes</option>
                    <option value="Facebook C" <?php echo ($row['area_asignada'] == 'Facebook C') ? 'selected' : ''; ?>>Facebook C</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" value="Enviar">
            </div>
        </form>

</div>


<?php
    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "ID de registro no proporcionado.";
}

include "../templates/pie.php";
?>