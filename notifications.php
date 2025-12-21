<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

// Fetch residents
$stmt = $conn->prepare("SELECT * FROM residents ORDER BY registered_at DESC");
$stmt->execute();
$residents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Residents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="dashboard.php" class="btn btn-secondary">Back</a>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>👥 Registered Residents</h3>
        <a href="add_resident.php" class="btn btn-success">
            ➕ Add Resident
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Resident Code</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Barangay</th>
                    <th>City</th>
                    <th>Date Registered</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($residents)): ?>
                    <?php foreach ($residents as $row): ?>
                        <tr>
                            <td class="text-center"><?= $row['resident_id'] ?></td>
                            <td><?= htmlspecialchars($row['resident_code']) ?></td>
                            <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['gender']) ?></td>
                            <td><?= htmlspecialchars($row['contact_number']) ?></td>
                            <td><?= htmlspecialchars($row['barangay']) ?></td>
                            <td><?= htmlspecialchars($row['city']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['registered_at']) ?></td>
                            <td class="text-center">
                                <a href="delete_resident.php?id=<?= $row['resident_id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this resident?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            No residents found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
