<?php
session_start(); 

if (!isset($_SESSION['resident_code'])) {
    // Redirect to login or handle error
    header("Location: login.php");
    exit();
}
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resident_code = $_SESSION['resident_code'];
    $emergency_type = trim($_POST['emergency_type']);
    $description = trim($_POST['description']);
    $status = 'Pending'; // default

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
<div class="d-flex justify-content-center mt-3">
    <a href="mobile_about.php" class="btn btn-outline-secondary w-50">
        About • FAQ • Training
    </a>
</div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white text-center">
                    <h5 class="mb-0">  Report Emergency</h5>
                </div>

                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-info text-center">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <!-- Resident Code -->
                     

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
                   

                        <!-- Buttons -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-danger">Submit Emergency</button>
                            
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
