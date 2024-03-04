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
$query = "SELECT area_asignada, COUNT(*) as cantidad 
          FROM registro_empleados 
          WHERE estatus = 'activo' 
          GROUP BY area_asignada";
$result = $conn->query($query);

// Crear un array para almacenar los datos del gráfico
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['area_asignada']] = $row['cantidad'];
}

// Cierra la conexión a la base de datos
$conn->close();
?>
<?php  include "../templates/cabecera.php" ?>
<div id='historial'>
    <h2>Areas de trabajo</h2>
    <br>
    <h3>Areas con trabajadores activos</h3>
    <div class="chart-container">
    <div>
        <canvas id="myBarChart"></canvas>
    </div>
    <br>
    <br>
    <div>
        <canvas id="myPieChart"></canvas>
    </div>
</div>

</div>
<script>
    // Datos obtenidos de PHP
    var data = <?php echo json_encode($data); ?>;
    var labels = Object.keys(data);
    var values = Object.values(data);

    // Crea el gráfico de barras
    var ctx = document.getElementById('myBarChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad de Empleados por Área',
                data: values,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    // Datos obtenidos de PHP
    var data = <?php echo json_encode($data); ?>;
    var labels = Object.keys(data);
    var values = Object.values(data);

    // Crea el gráfico de pastel
    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                ],
            }]
        }
    });
</script>
<?php  include "../templates/pie.php" ?>
