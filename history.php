<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/config/Database.php';

$db = new Database();
$conn = $db->connect();

/* Fetch last 7 days of sensor data */
$sql = "
SELECT *
FROM (
    SELECT 
        DATE(created_at) AS day,
        AVG(humidity) AS avg_humidity,
        AVG(temperature) AS avg_temperature
    FROM sensor_readings
    WHERE device_id = :device_id
    GROUP BY DATE(created_at)
    ORDER BY day DESC
    LIMIT 7
) AS sub
ORDER BY day ASC
";

$stmt = $conn->prepare($sql);
$stmt->execute(['device_id' => 'ESP32-001']);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Prepare chart arrays */
$days = [];
$humidityData = [];
$temperatureData = [];

foreach ($data as $row) {
    $days[] = date("D", strtotime($row['day']));
    $humidityData[] = round($row['avg_humidity'], 2);
    $temperatureData[] = round($row['avg_temperature'], 2);
}

/* Prevent empty chart */
if (empty($days)) {
    $days = ["No Data"];
    $humidityData = [0];
    $temperatureData = [0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">System History Reports</h2>

    <!-- Chart canvas -->
    <canvas id="historyChart" height="100"></canvas>
</div>

<script>
// Initialize chart with PHP data
let chartLabels = <?php echo json_encode($days); ?>;
let humidityData = <?php echo json_encode($humidityData); ?>;
let temperatureData = <?php echo json_encode($temperatureData); ?>;

const ctx = document.getElementById('historyChart').getContext('2d');

const historyChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartLabels,
        datasets: [
            {
                label: 'Water Level (%)',
                data: humidityData,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.3
            },
            {
                label: 'Humidity (°C)',
                data: temperatureData,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: { display: true, text: 'Last 7 Days System Data' }
        },
        scales: { y: { beginAtZero: true } }
    }
});

// Fetch live data every 10 seconds and update chart
async function fetchLiveData() {
    try {
        // Insert new remote data
        await fetch('fetch_remote_data.php');

        // Fetch updated chart data
        const response = await fetch('history_data.php');
        const chartData = await response.json();

        // Update chart
        historyChart.data.labels = chartData.days;
        historyChart.data.datasets[0].data = chartData.humidity;
        historyChart.data.datasets[1].data = chartData.temperature;
        historyChart.update();

    } catch (err) {
        console.error('Error fetching live data:', err);
    }
}

// Start interval
setInterval(fetchLiveData, 24 * 60 * 60 * 1000);
</script>
</body>
</html>
