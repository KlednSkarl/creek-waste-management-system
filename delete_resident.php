<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid request.");
}

$stmt = $conn->prepare("DELETE FROM residents WHERE resident_id = ?");
$stmt->execute([$id]);

header("Location: notifications.php");
exit;
