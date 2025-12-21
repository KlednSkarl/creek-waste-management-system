<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resident_code = trim($_POST['resident_code']);
    $emergency_type = trim($_POST['emergency_type']);
    $description = trim($_POST['description']);
    $status = trim($_POST['emergency_status']);

    if ($resident_code === '' || $emergency_type === '' || $status === '') {
        $message = "Please fill in all required fields.";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO emergency 
            (resident_code, emergency_type, description, emergency_status)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$resident_code, $emergency_type, $description, $status]);

        $message = "Emergency record added successfully.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Emergency</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white text-center">
                    <h5 class="mb-0">🚨 Report Emergency</h5>
                </div>

                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-info text-center">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <!-- Resident Code -->
                        <div class="mb-3">
                            <label class="form-label">Resident Code *</label>
                            <input type="text" name="resident_code" class="form-control" required>
                        </div>

                        <!-- Emergency Type -->
                        <div class="mb-3">
                            <label class="form-label">Emergency Type *</label>
                            <select name="emergency_type" class="form-select" required>
                                <option value="">Select type</option>
                                <option>Flood</option>
                                <option>Evacuation</option>
                                <option>Injury</option>
                                <option>Rescue</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Status *</label>
                            <select name="emergency_status" class="form-select" required>
                                <option value="">Select status</option>
                                <option>Pending</option>
                                <option>Responding</option>
                                <option>Resolved</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-danger">Submit Emergency</button>
                            <a href="emergency.php" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
