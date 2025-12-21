<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

$rainfall = [];

try {
    $stmt = $conn->prepare("
        SELECT 
            record_date,
            rainfall_amount,
            rainfall_level,
            remarks
        FROM rainfall_history
        ORDER BY record_date DESC
    ");
    $stmt->execute();
    $rainfall = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rainfall History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="dashboard.php" class="btn btn-secondary">Back</a>
<div class="container mt-5">
    <h3 class="mb-4 text-center">🌧️ Rainfall History</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Date</th>
                    <th>Rainfall (mm)</th>
                    <th>Level</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rainfall)): ?>
                    <?php foreach ($rainfall as $row): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($row['record_date']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['rainfall_amount']) ?></td>
                            <td class="text-center">
                                <span class="badge 
                                    <?= $row['rainfall_level'] === 'Heavy' ? 'bg-danger' :
                                       ($row['rainfall_level'] === 'Moderate' ? 'bg-warning text-dark' : 'bg-success') ?>">
                                    <?= htmlspecialchars($row['rainfall_level']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['remarks']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No rainfall records found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
