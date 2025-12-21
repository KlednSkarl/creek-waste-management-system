<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

// GET ID
$id = $_GET['id'] ?? 0;

if (!$id) {
    header("Location: creek.php");
    exit;
}

// DELETE RECORD
$sql = "DELETE FROM creek WHERE creek_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

// REDIRECT BACK
header("Location: creek.php");
exit;
