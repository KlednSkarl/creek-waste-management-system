<?php
session_start();
require_once __DIR__ . '/config/Database.php';

header("Content-Type: application/json");

if (!isset($_SESSION['username'])) {
    echo json_encode([
        "success" => false,
        "error" => "Session expired"
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['emergency_id'])) {
    echo json_encode([
        "success" => false,
        "error" => "Missing emergency ID"
    ]);
    exit;
}

$emergency_id = intval($data['emergency_id']);

try {
    $database = new Database();
    $conn = $database->connect();

    $stmt = $conn->prepare("
        UPDATE emergency 
        SET emergency_status = 'Done' 
        WHERE emergency_id = ?
    ");
    $stmt->execute([$emergency_id]);

    echo json_encode([
        "success" => true
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
