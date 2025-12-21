<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

// GET ID
$id = $_GET['id'] ?? 0;

// FETCH DATA
$stmt = $conn->prepare("SELECT * FROM creek WHERE creek_id = ?");
$stmt->execute([$id]);
$creek = $stmt->fetch();

if (!$creek) {
    die("Creek record not found.");
}

// UPDATE DATA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE creek 
            SET creek_name = ?, creek_code =?,location = ?, barangay = ?, city = ?
            WHERE creek_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['creek_name'],
        $_POST['creek_code'],
        $_POST['location'],
        $_POST['barangay'],
        $_POST['city'],
        $id
    ]);

    header("Location: creek.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Creek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header fw-bold">Edit Creek</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Creek Name</label>
                    <input type="text" name="creek_name" class="form-control"
                           value="<?= htmlspecialchars($creek['creek_name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Creek Code</label>
                    <input type="text" name="creek_code" class="form-control"
                           value="<?= htmlspecialchars($creek['creek_code']) ?>">
                </div>

                  <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control"
                           value="<?= htmlspecialchars($creek['location']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Barangay</label>
                    <input type="text" name="barangay" class="form-control"
                           value="<?= htmlspecialchars($creek['barangay']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control"
                           value="<?= htmlspecialchars($creek['city']) ?>">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="creek.php" class="btn btn-secondary">Cancel</a>
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>