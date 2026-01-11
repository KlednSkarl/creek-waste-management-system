<?php
require_once __DIR__ . '/config/Database.php';
$database = new Database();
$conn = $database->connect();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resident_code   = trim($_POST['resident_code']);
    $first_name      = trim($_POST['first_name']);
    $last_name       = trim($_POST['last_name']);
    $gender          = $_POST['gender'] ?? '';
    $birth_date      = $_POST['birth_date'] ?? '';
    $contact_number  = trim($_POST['contact_number']);
    $email           = trim($_POST['email']);
    $address         = trim($_POST['address']);
    $barangay        = trim($_POST['barangay']);
    $city            = trim($_POST['city']);

    if ($resident_code === '' || $first_name === '' || $last_name === '' || $birth_date === '' || $email === '') {
        $message = "Please fill in all required fields.";
    } else {

        // Calculate age
        $birth = new DateTime($birth_date);
        $today = new DateTime();
        $age = $today->diff($birth)->y;

        // Handle image upload
        $profile_image = null;
        if (!empty($_FILES['profile_image']['name'])) {
            $folder = "uploads/residents/";
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            $filename = time() . "_" . basename($_FILES['profile_image']['name']);
            $path = $folder . $filename;

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $path)) {
                $profile_image = $path;
            }
        }

        // Insert resident
        $stmt = $conn->prepare("
            INSERT INTO residents
            (resident_code, first_name, last_name, gender, birth_date, age,
             contact_number, email, address, barangay, city, profile_image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $resident_code,
            $first_name,
            $last_name,
            $gender,
            $birth_date,
            $age,
            $contact_number,
            $email,
            $address,
            $barangay,
            $city,
            $profile_image
        ]);

        $message = "Registration successful.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Resident Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Resident Registration</h5>
                </div>

                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">

                        <input class="form-control mb-2" name="resident_code" placeholder="Resident Code *" required>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input class="form-control" name="first_name" placeholder="First Name *" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input class="form-control" name="last_name" placeholder="Last Name *" required>
                            </div>
                        </div>

                        <select class="form-select mb-2" name="gender" required>
                            <option value="">Select Gender *</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>

                        <input type="date" class="form-control mb-2" name="birth_date" required>

                        <input class="form-control mb-2" name="contact_number" placeholder="Contact Number">

                        <input type="email" class="form-control mb-2" name="email" placeholder="Email *" required>

                        <textarea class="form-control mb-2" name="address" placeholder="Address"></textarea>

                        <input class="form-control mb-2" name="barangay" placeholder="Barangay">

                        <input class="form-control mb-2" name="city" placeholder="City">

                        <label class="form-label">Profile Image</label>
                        <input type="file" class="form-control mb-3" name="profile_image" accept="image/*">

                        <button class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
