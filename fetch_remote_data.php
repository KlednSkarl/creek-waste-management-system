<?php
header("Content-Type: text/plain");

require_once __DIR__ . '/config/Database.php';

// 1️⃣ Database connection
$db = new Database();
$conn = $db->connect();

// 2️⃣ Render API URL
$apiUrl = "https://receiver-creek-flood-tracker.onrender.com/receiver.php";

// 3️⃣ Fetch last reading
$response = file_get_contents($apiUrl); // simple GET now

if ($response === false) {
    die("Failed to fetch data from Render API");
}

$data = json_decode($response, true);
if ($data === null) {
    die("Invalid JSON from API: " . json_last_error_msg());
}

// 4️⃣ Extract fields
$deviceId = $data['device_id'] ?? null;
$temperature = $data['temperature'] ?? null;
$humidity = $data['humidity'] ?? null;

if ($deviceId === null || $temperature === null) {
    die("API returned incomplete data");
}

// 5️⃣ Insert into local MySQL
try {
    $stmt = $conn->prepare("
        INSERT INTO sensor_readings (device_id, temperature, humidity)
        VALUES (:device_id, :temperature, :humidity)
    ");
    $stmt->execute([
        ":device_id" => $deviceId,
        ":temperature" => $temperature,
        ":humidity" => $humidity
    ]);
    echo "Data successfully inserted: Device=$deviceId, Temp=$temperature, Humidity=$humidity\n";
} catch (PDOException $e) {
    die("Database insert error: " . $e->getMessage());
}
