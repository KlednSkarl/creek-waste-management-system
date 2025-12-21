<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Sample data  
$trashCollected = [5, 7, 6, 8, 4, 7, 5]; // kg per day
$days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];

$waterLevel = [1.2, 1.5, 2.0, 2.5, 2.3, 1.8, 1.6]; // meters
$rainEvents = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];

$systemUtilization = [60, 75, 80, 70, 85, 90, 65]; // %
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">System History Reports</h2>

    <div class="row g-4">
        <!-- Trash Collected -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center">Trash Collected Per Day (kg)</h5>
                    <canvas id="trashChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Water Level -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center">Water Level Trends (meters)</h5>
                    <canvas id="waterChart"></canvas>
                </div>
            </div>
        </div>

        <!-- System Utilization -->
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center">System Utilization (%)</h5>
                    <canvas id="utilizationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Trash Collected Chart
    const trashCtx = document.getElementById('trashChart').getContext('2d');
    const trashChart = new Chart(trashCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($days) ?>,
            datasets: [{
                label: 'Trash Collected (kg)',
                data: <?= json_encode($trashCollected) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });

    // Water Level Chart
    const waterCtx = document.getElementById('waterChart').getContext('2d');
    const waterChart = new Chart(waterCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($rainEvents) ?>,
            datasets: [{
                label: 'Water Level (m)',
                data: <?= json_encode($waterLevel) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });

    // System Utilization Chart
    const utilCtx = document.getElementById('utilizationChart').getContext('2d');
    const utilizationChart = new Chart(utilCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($days) ?>,
            datasets: [{
                label: 'System Utilization (%)',
                data: <?= json_encode($systemUtilization) ?>,
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true, max: 100 } }
        }
    });
</script>
</body>
</html>
