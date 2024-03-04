<?php
session_start();

// Verificar si la sesión está activa y la cookie está configurada
if (!isset($_SESSION['usuario']) || !isset($_COOKIE['sesion_activa'])) {
    header("Location: ../index.php");
    exit(); // Asegura que el script se detenga después de la redirección
}

?>
<?php  include "../templates/cabecera.php" ?>

<div id="formulario">
        <h1>Formulario de Contratacion</h1>
        <form id="miFormulario" action="../configuraciones/subir.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre_completo">Nombre Completo:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" required>
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required><br>
            </div>
            
            
            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" id="fecha_ingreso" name="fecha_ingreso" required><br>
            </div>

            <div class="form-group">
                <label for="estatus">Estatus:</label>
                    <select id="estatus" name="estatus">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telefono_celular">Teléfono Celular:</label>
                <input type="tel" id="telefono_celular" name="telefono_celular" required><br>
            </div>
            <div class="form-group">
                <label for="correo_electronico">Correo Electrónico:</label>
                <input type="email" id="correo_electronico" name="correo_electronico" required><br>
            </div>
            <div class="form-group">
                <label for="nombre_contacto">Nombre de Contacto:</label>
                <input type="text" id="nombre_contacto" name="nombre_contacto"><br>
            </div>
            <div class="form-group">
                <label for="telefono_contacto">Teléfono de Contacto:</label>
                <input type="tel" id="telefono_contacto" name="telefono_contacto"><br>
            </div>
            <div class="form-group">
                <label for="sueldo_quincenal">Sueldo Quincenal:</label>
                <input type="number" id="sueldo_quincenal" name="sueldo_quincenal" step="0.01" required><br>
            </div>
            <div class="form-group">
                <label for="horario_trabajo">Horario de Trabajo:</label>
                <input type="text" id="horario_trabajo" name="horario_trabajo" required><br>
            </div>
            <div class="form-group">
                <label for="numero_seguridad_social">Número de Seguro Social:</label>
                <input type="text" id="numero_seguridad_social" name="numero_seguridad_social"><br>
            </div>
            <div class="form-group">
                <label for="fecha_alta_seguridad_social">Fecha de Alta en Seguro Social:</label>
                <input type="date" id="fecha_alta_seguridad_social" name="fecha_alta_seguridad_social"><br>
            </div>
            <div class="form-group">
                <label for="redes_sociales">Redes Sociales:</label>
                <input type="text" id="redes_sociales" name="redes_sociales"><br>
            </div>
            <div class="form-group">
                <label for="area">Area asignada:</label>
                <label for="area">Area asignada:</label>
                    <select id="area" name="area">
                        <option value="Hercules 1">Hercules 1</option>
                        <option value="Hercules 2">Hercules 2</option>
                        <option value="Hercules 3">Hercules 3</option>
                        <option value="Hercules 4">Hercules 4</option>
                        <option value="Twitter">Twitter</option>
                        <option value="Whatsaap Grupos">Whatsaap Grupos</option>
                        <option value="Whatsaap Individuales">Whatsaap Grupos</option>
                        <option value="Facebook Cancun">Facebook Cancun</option>
                        <option value="Facebook CDMX">Facebook CDMX</option>
                        <option value="Periodicos">Periodicos</option>
                        <option value="Monitoreo">Monitoreo</option>
                        <option value="Ventas">Ventas</option>
                        <option value="Reportes">Reportes</option>
                        <option value="Facebook C">Facebook C</option>
                    </select>
            </div>
            <div>
            <label for="archivos">Seleccione sus archivos:</label>
            <input type="file" name="archivos[]" id="archivos" multiple accept=".jpg, .png, .pdf"><!-- "multiple" permite seleccionar múltiples archivos -->
            </div> 
            <br>
            <div class="form-group">
                <input type="submit" value="Enviar">
            </div>
        </form>
    </div>



<?php  include "../templates/pie.php" ?>