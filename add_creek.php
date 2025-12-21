<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

// BASIC VALIDATION
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: creek.php");
    exit;
}

$creek_name = trim($_POST['creek_name'] ?? '');
$creek_code = trim($_POST['creek_code'] ?? '');
$location   = trim($_POST['location'] ?? '');
$barangay   = trim($_POST['barangay'] ?? '');
$city       = trim($_POST['city'] ?? '');

if ($creek_name === '') {
    header("Location: creek.php");
    exit;
}

// INSERT DATA
$sql = "INSERT INTO creek (creek_name,creek_code, location, barangay, city)
        VALUES (?,?,?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->execute([$creek_name,$creek_code, $location, $barangay, $city]);

// REDIRECT BACK
header("Location: creek.php");
exit;