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

<?php if (isset($_GET['activated'])): ?>
    <div class="alert alert-success text-center">
        Resident activated successfully ✅
    </div>
<?php endif; ?>


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
                        <tr class="<?= ((int)$row['is_active'] === 1) ? 'table-success' : '' ?>">
                            <td class="text-center"><?= $row['resident_id'] ?></td>
                            <td><?= htmlspecialchars($row['resident_code']) ?></td>
                            <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['gender']) ?></td>
                            <td><?= htmlspecialchars($row['contact_number']) ?></td>
                            <td><?= htmlspecialchars($row['barangay']) ?></td>
                            <td><?= htmlspecialchars($row['city']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['registered_at']) ?></td>
                           <td class="text-center">

    <!-- View Image Button -->
    <button 
        class="btn btn-sm btn-primary mb-1"
        data-bs-toggle="modal"
        data-bs-target="#imageModal<?= $row['resident_id'] ?>">
         View
    </button>

    <!-- Show only if is_active = 0 -->
    <?php if ((int)$row['is_active'] === 0): ?>
        <a href="activate_resident.php?id=<?= $row['resident_id'] ?>"
           class="btn btn-sm btn-warning mb-1"
           onclick="return confirm('Activate this resident?')">
           Activate
        </a>
    <?php endif; ?>

    <!-- Delete -->
    <a href="delete_resident.php?id=<?= $row['resident_id'] ?>"
       class="btn btn-sm btn-danger"
       onclick="return confirm('Delete this resident?')">
       Delete
    </a>
</td>
                        </tr>
<!-- Image Modal -->
<div class="modal fade" id="imageModal<?= $row['resident_id'] ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <?php if (!empty($row['profile_image'])): ?>
                    <img 
                        src="<?= htmlspecialchars($row['profile_image']) ?>"
                        class="img-fluid rounded"
                        alt="Resident Image">
                <?php else: ?>
                    <p class="text-muted">No image available</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



                        
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
