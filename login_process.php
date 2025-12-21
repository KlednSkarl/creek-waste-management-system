<?php
session_start();
require_once __DIR__ .  "/config/Database.php";

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST['username']]);
$user = $stmt->fetch();

if ($user && password_verify($_POST['password'], $user['password'])) {
    
    $_SESSION['username'] = $user['username'];
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: login.php?error=1");
    exit();
}