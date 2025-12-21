<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

// Get status_id from URL
$status_id = $_GET['id'] ?? null;

if (!$status_id) {
    die("Invalid request.");
}

// Delete the status
$stmt = $conn->prepare("DELETE FROM creek_status WHERE status_id = ?");
$stmt->execute([$status_id]);

// Redirect back to creek page
header("Location: creek.php");
exit;
