<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

$creek_code = trim($_POST['creek_code'] ?? '');

if ($creek_code === '') {
    die("Please provide a creek code.");
}

// Get creek by code
$stmt = $conn->prepare("SELECT creek_id, creek_name,creek_code FROM creek WHERE creek_code = ?");
$stmt->execute([$creek_code]);
$creek = $stmt->fetch();

if (!$creek) {
    die("Creek not found.");
}

// Get latest status
$stmt = $conn->prepare("
    SELECT  status, status_date,creek_code,status_id,Remarks
    FROM creek_status
    WHERE creek_code = ?
    ORDER BY status_date DESC
    LIMIT 1
");
$stmt->execute([$creek['creek_code']]);
$status = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creek Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Creek: <?= htmlspecialchars($creek['creek_name']) ?> (<?= htmlspecialchars($creek_code) ?>)</h2>

    <?php if ($status): ?>
        <table class="table table-bordered w-50">
            <thead class="table-dark">
                <tr>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Creek Code</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($status['status']) ?></td>
                    <td><?= htmlspecialchars($status['status_date']) ?></td>
                    <td><?= htmlspecialchars($status['creek_code']) ?></td>
                    <td><?= htmlspecialchars($status['Remarks']) ?></td>
                     <td class="text-center">
                <a href="delete_status.php?id=<?= $status['status_id'] ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Delete this status?')">Delete</a>
            </td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-warning">No status records found for this creek.</p>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStatusModal">
            ➕ Add Status
        </button>
    <?php endif; ?>

    <a href="creek.php" class="btn btn-secondary mt-3">Back</a>
</div>

<!-- ADD STATUS MODAL -->
<div class="modal fade" id="addStatusModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="add_creek_status.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="creek_code" value="<?= $creek['creek_code'] ?>">
        <input type="text" name="status" class="form-control mb-2" placeholder="Status (Normal/High/Flood)" required>
        <input type="text" name="water_level" class="form-control mb-2" placeholder="Creek Code" required>
        <textarea name="notes" class="form-control" placeholder="Notes (optional)"></textarea>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save Status</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>