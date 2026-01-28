<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require_once __DIR__ . '/config/Database.php';

// CREATE DATABASE OBJECT
$database = new Database();

// CONNECT
$conn = $database->connect();

// FETCH DATA FROM creek TABLE
$sql = "SELECT creek_id, creek_code, creek_name, location, barangay, city FROM creek";
$stmt = $conn->prepare($sql);
$stmt->execute();
$creeks = $stmt->fetchAll();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Water Level</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<a href="dashboard.php" class="btn btn-secondary">Back</a>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Creek Water Level</h2>

    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">Current Level</h5>
            <p class="card-text"><strong>Normal</strong></p>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mb-3  p-3 bg-light rounded">
    <button class="btn btn-primary"   data-bs-toggle="modal" data-bs-target="#addCreekModal">
        ➕ Add Creek
    </button>

   <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkCreekStatus">
        ➕ Check Creek Status
    </button>
</div>

 

   <!-- TABLE -->
    <div class="card">
        <div class="card-header fw-bold">Creek List</div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th> 
                        <th>Code</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Barangay</th>
                        <th>City</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($creeks): ?>
                    <?php foreach ($creeks as $row): ?>
                        <tr>
                            <td class="text-center"><?= $row['creek_id'] ?></td>
                            <td><?= htmlspecialchars($row['creek_code']) ?></td>
                            <td><?= htmlspecialchars($row['creek_name']) ?></td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td><?= htmlspecialchars($row['barangay']) ?></td>
                            <td><?= htmlspecialchars($row['city']) ?></td>
                            <td class="text-center">
                                <a href="edit_creek.php?id=<?= $row['creek_id'] ?>" 
                                   class="btn btn-sm btn-warning">Edit</a>

                                <a href="delete_creek.php?id=<?= $row['creek_id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this creek?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No records found</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>





<div class="modal fade" id="addCreekModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="add_creek.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Creek</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="text" name="creek_name" class="form-control mb-2" placeholder="Creek Name" required>
        <input type="text" name="creek_code" class="form-control mb-2" placeholder="Creek Code" required>
        <input type="text" name="location" class="form-control mb-2" placeholder="Location">
        <input type="text" name="barangay" class="form-control mb-2" placeholder="Barangay">
        <input type="text" name="city" class="form-control mb-2" placeholder="City">
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </form>
  </div>
</div>


<!-- Checking for Creek Status -->
<div class="modal fade" id="checkCreekStatus" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="check_creek_status.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Check Creek Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
         <input type="text" name="creek_code" class="form-control mb-2" placeholder="Creek Code" required>
   
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Check</button>
      </div>
    </form>
  </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
