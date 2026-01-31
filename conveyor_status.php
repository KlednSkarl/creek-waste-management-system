<?php
// Manila coordinates
$latitude = 14.5995;
$longitude = 120.9842;

// Open-Meteo API URL
$apiUrl = "https://api.open-meteo.com/v1/forecast?"
    . "latitude={$latitude}&longitude={$longitude}"
    . "&hourly=precipitation,precipitation_probability"
    . "&timezone=Asia/Manila";

// Fetch the data
$response = file_get_contents($apiUrl);
if ($response === false) die("Failed to fetch weather data");

$data = json_decode($response, true);
if (!$data) die("Invalid JSON response from API");

// Extract hourly forecast
$hourlyForecast = [];
if (isset($data['hourly']['time'])) {
    foreach ($data['hourly']['time'] as $i => $time) {
        $hourlyForecast[] = [
            "time" => $time,
            "rain_mm" => $data['hourly']['precipitation'][$i] ?? 0,
            "chance_percent" => $data['hourly']['precipitation_probability'][$i] ?? 0
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manila Rain Forecast</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.table-row { cursor: pointer; }
.table-row:hover { background-color: #f0f0f0; }
</style>
</head>
<body class="p-4">
<h2>Manila Hourly Rain Forecast</h2>
<table class="table table-bordered table-striped mt-3">
    <thead class="table-dark">
        <tr>
            <th>Time</th>
            <th>Rain Volume (mm)</th>
            <th>Chance of Rain (%)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hourlyForecast as $hour): ?>
            <tr class="table-row"
                data-chance="<?= htmlspecialchars($hour['chance_percent']) ?>"
                data-time="<?= htmlspecialchars($hour['time']) ?>"
                data-rain="<?= htmlspecialchars($hour['rain_mm']) ?>">
                <td><?= htmlspecialchars($hour['time']) ?></td>
                <td><?= htmlspecialchars($hour['rain_mm']) ?></td>
                <td><?= htmlspecialchars($hour['chance_percent']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
// Add click event to all rows
document.querySelectorAll('.table-row').forEach(row => {
    row.addEventListener('click', () => {
        const chance = parseFloat(row.dataset.chance);
        const time = row.dataset.time;
        const rain = row.dataset.rain;

        let message = `Time: ${time}\nRain Volume: ${rain} mm\nChance of Rain: ${chance}%\n`;

        if (chance < 30) {
            message += "Low chance of rain 🌤️";
        } else if (chance < 70) {
            message += "Moderate chance of rain ☁️";
        } else {
            message += "High chance of rain 🌧️ Take precautions!";
        }

        alert(message);
    });
});
</script>
</body>
</html>
