<?php
header("Content-Type: application/json");
require_once __DIR__ . '/config/Database.php';

$db = new Database();
$conn = $db->connect();

$apiUrl = "https://receiver-creek-flood-tracker.onrender.com/receiver.php";

$response = file_get_contents($apiUrl);

if ($response === false) {
    echo json_encode(["status" => "error", "message" => "Failed to fetch API"]);
    exit;
}

$data = json_decode($response, true);
if ($data === null) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit;
}

$deviceId = $data['device_id'] ?? null;
$temperature = $data['temperature'] ?? null;
$humidity = $data['humidity'] ?? null;

if ($deviceId === null || $temperature === null || $humidity === null) {
    echo json_encode(["status" => "error", "message" => "Incomplete API data"]);
    exit;
}

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
    echo json_encode(["status" => "success"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
