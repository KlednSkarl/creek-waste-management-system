<?php

 
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

$emergencies = [];

try {
    $stmt = $conn->prepare("SELECT * FROM emergency ORDER BY reported_date DESC");
    $stmt->execute();
    $emergencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
 



session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emergency Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="dashboard.php" class="btn btn-secondary">Back</a>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Resident Code</th>
            <th>Emergency Type</th>
            <th>Description</th>
            <th>Status</th>
            <th>Date Reported</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($emergencies as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['resident_code']) ?></td>
            <td><?= htmlspecialchars($row['emergency_type']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['emergency_status']) ?></td>
            <td><?= htmlspecialchars($row['reported_date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>








 
</body>
</html>
