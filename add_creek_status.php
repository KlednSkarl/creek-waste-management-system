<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: creek.php");
    exit;
}

// Get posted values
$creek_code = trim($_POST['creek_code'] ?? '');
$status = $_POST['status'] ?? '';
$water_level = $_POST['water_level'] ?? '';
$notes = $_POST['notes'] ?? '';

// Validate input
if ($creek_code === '' || $status === ''  ) {
    die("All required fields must be filled.");
}

// Get creek_id from creek_code
$stmt = $conn->prepare("SELECT creek_code FROM creek WHERE creek_code = ?");
$stmt->execute([$creek_code]);
$creek = $stmt->fetch();

if (!$creek) {
    die("Invalid creek code.");
}

$creek_code = $creek['creek_code'];

// Insert into creek_status
$sql = "INSERT INTO creek_status (creek_code, status, remarks) VALUES (?,  ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$creek_code, $status, $notes]);

// Redirect back to creek page
header("Location: creek.php");
exit;
