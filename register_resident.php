<?php
require_once __DIR__ . '/config/Database.php';
$database = new Database();
$conn = $database->connect();
 
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     
    $first_name      = trim($_POST['first_name']);
    $last_name       = trim($_POST['last_name']);
    $gender          = $_POST['gender'] ?? '';
    $birth_date      = $_POST['birth_date'] ?? '';
    $contact_number  = trim($_POST['contact_number']);
    $email           = trim($_POST['email']);
    $address         = trim($_POST['address']);
    $barangay        = trim($_POST['barangay']);
    $city            = trim($_POST['city']);

    if (  $first_name === '' || $last_name === '' || $birth_date === '' || $email === '') {
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

        // Generate next resident_code
$stmt = $conn->query("
    SELECT resident_code 
    FROM residents 
    ORDER BY resident_id DESC 
    LIMIT 1
");

$lastCode = $stmt->fetchColumn();

if ($lastCode) {
    $number = (int) substr($lastCode, 4); // RES-001 → 001
    $newNumber = $number + 1;
} else {
    $newNumber = 1;
}

$resident_code = 'RES-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);


$hasError = false;
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if ($password === '' || strlen($password) < 6) {
    $message = "Password must be at least 6 characters.";
    $hasError = true;
}

if ($password !== $confirm_password) {
    $message = "Passwords do not match.";
    $hasError = true;
}
}

// Secure hashing
$password_hash = password_hash($password, PASSWORD_DEFAULT);

    if (!$hasError) {
        // Insert resident
        $stmt = $conn->prepare("
            INSERT INTO residents
            (resident_code, first_name, last_name, gender, birth_date, age,
             contact_number, email, address, barangay, city, profile_image,password_hash)
            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)
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
            $profile_image,
            $password_hash
        ]);

        $message = "Registration successful.";
    }
}


function old($key) {
    return htmlspecialchars($_POST[$key] ?? '', ENT_QUOTES);
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

       
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input class="form-control" name="first_name"   value="<?= old('first_name') ?>" placeholder="First Name *" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input class="form-control" name="last_name" value="<?= old('last_name') ?>" placeholder="Last Name *" required>
                            </div>
                        </div>

                        <select class="form-select mb-2" name="gender" required>
                            <option value="">Select Gender *</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>

                        <input type="date" class="form-control mb-2" name="birth_date" required>

                        <input class="form-control mb-2" name="contact_number" value="<?= old('contact_number') ?>" placeholder="Contact Number">

                        <input type="email" class="form-control mb-2" name="email" value="<?= old('email') ?>" placeholder="Email *" required>

                        <textarea class="form-control mb-2" name="address" placeholder="Address"><?= old('address') ?></textarea>
                        <input class="form-control mb-2" name="barangay" value="<?= old('barangay') ?>" placeholder="Barangay">

                        <input class="form-control mb-2" name="city" value="<?= old('city') ?>" placeholder="City">

                        <label class="form-label">Profile Image</label>
                        <input type="file" class="form-control mb-3" name="profile_image" accept="image/*">
                        <input type="password" class="form-control mb-2" name="password" placeholder="Password *" required>
                        <input type="password" class="form-control mb-2" name="confirm_password" placeholder="Confirm Password *" required>
                        <button class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
