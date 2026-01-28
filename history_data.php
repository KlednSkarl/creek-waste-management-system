<?php
header("Content-Type: application/json");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once __DIR__ . '/config/Database.php';

$db = new Database();
$conn = $db->connect();

// Fetch last 7 readings for device ESP32-001
$sql = "
SELECT *
FROM (
    SELECT *
    FROM sensor_readings
    WHERE device_id = :device_id
    ORDER BY created_at DESC
    LIMIT 7
) AS sub
ORDER BY created_at ASC
";

$stmt = $conn->prepare($sql);
$stmt->execute(['device_id' => 'ESP32-001']);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$days = [];
$humidity = [];
$temperature = [];

foreach ($data as $row) {
    // Use time for x-axis (last 7 readings)
    $days[] = date("H:i", strtotime($row['created_at']));
    $humidity[] = round($row['humidity'], 2);
    $temperature[] = round($row['temperature'], 2);
}

// Prevent empty chart
if (empty($days)) {
    $days = ["No Data"];
    $humidity = [0];
    $temperature = [0];
}

echo json_encode([
    "days" => $days,
    "humidity" => $humidity,
    "temperature" => $temperature
]);
