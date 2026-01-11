<?php
require_once __DIR__ . '/config/Database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: residents.php");
    exit;
}

$resident_id = (int) $_GET['id'];

$database = new Database();
$conn = $database->connect();

/* Activate resident */
$stmt = $conn->prepare("
    UPDATE residents
    SET is_active = 1
    WHERE resident_id = :id
");

$stmt->execute([
    ':id' => $resident_id
]);

header("Location: notifications.php?activated=1");
exit;
