<?php
session_start();

// Verificar si la sesión está activa y la cookie está configurada
if (!isset($_SESSION['usuario']) || !isset($_COOKIE['sesion_activa'])) {
    header("Location: ../index.php");
    exit(); // Asegura que el script se detenga después de la redirección
}

?>
<?php 
$host = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "db_globales";

$conn = new mysqli($host, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
$query = "SELECT id,nombre_completo, fecha_nacimiento, direccion, fecha_ingreso, estatus, telefono_celular, correo_electronico,nombre_contacto,telefono_contacto,sueldo_quincenal,horario_trabajo,numero_seguridad_social,fecha_alta_seguro_social,redes_sociales,area_asignada,archivos FROM registro_empleados";
$result = $conn->query($query);


// Cierra la conexión a la base de datos
$conn->close();
?>
<?php  include "../templates/cabecera.php" ?>
<div id='historial'>
    <h2>Registros</h2>
    <br>
    <h2>Busqueda</h2>
    <br>
    <form id="searchForm2" onsubmit="return buscarEmpleados()">
        <input type="text" class='form-control' id='campoBusqueda'>
        <br>
        <input type="submit" id="searchButton" value="Buscar">
    </form>
    <div>
        <div>
            <table class="table" id="tablaDatos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Direccion</th>
                        <th>Fecha de Ingreso</th>
                        <th>Estatus</th>
                        <th>Telefono Celular</th>
                        <th>Correo</th>
                        <th>Sueldo</th>
                        <th>Horario</th>
                       <th>Redes Sociales</th>
                        <th>Area</th>
                        <th>Archivos</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody id="tablaDatosBody">
                    <?php 
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['nombre_completo']}</td>";
                            echo "<td>{$row['fecha_nacimiento']}</td>";
                            echo "<td>{$row['direccion']}</td>";
                            echo "<td>{$row['fecha_ingreso']}</td>";
                            echo "<td>{$row['estatus']}</td>";
                            echo "<td>{$row['telefono_celular']}</td>";
                            echo "<td>{$row['correo_electronico']}</td>";
                            echo "<td>{$row['sueldo_quincenal']}</td>";
                            echo "<td>{$row['horario_trabajo']}</td>";
                            echo "<td>{$row['redes_sociales']}</td>";
                            echo "<td>{$row['area_asignada']}</td>";
                            echo "<td><a href='#' onclick=\"openPopup('{$row['archivos']}')\">Enlace</a></td>";
                            echo "<td><a href='modificar.php?id={$row['id']}' class='editar-enlace'>Editar</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No se encontraron resultados</td></tr>";
                    }
                    
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    
</div>

<script>

function buscarEmpleados() {
    var input, filter, table, tbody, tr, tdNombre, i, txtValueNombre;
    input = document.getElementById("campoBusqueda");
    filter = input.value.toUpperCase();
    table = document.getElementById("tablaDatos");
    tbody = table.getElementsByTagName("tbody")[0];
    tr = tbody.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        tdNombre = tr[i].getElementsByTagName("td")[0];
        if (tdNombre) {
            txtValueNombre = tdNombre.textContent || tdNombre.innerText;
            if (txtValueNombre.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    return false;   
}


function openPopup(url) {
    var width = 800;
    var height = 600;
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;
    var options = 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',resizable=yes,scrollbars=yes';

    window.open(url, '_blank', options);
}

</script>
<?php  include "../templates/pie.php" ?>