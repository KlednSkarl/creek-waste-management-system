<?php
require_once __DIR__ . '/config/Database.php';

if (!isset($_GET['code'])) {
    http_response_code(400);
    exit;
}

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("
    SELECT *
    FROM residents
    WHERE resident_code = :code
    LIMIT 1
");

$stmt->execute([':code' => $_GET['code']]);
$resident = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resident) {
    http_response_code(404);
    exit;
}

echo json_encode($resident);
