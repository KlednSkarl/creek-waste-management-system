<?php
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

// session_start();
// if (!isset($_SESSION['resident_code'])) {
//     header("Location: login.php");
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Handle profile image upload
    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $uploadDir = __DIR__ . '/uploads/residents/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['profile_image']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
            $profile_image = $filename; // store only filename in DB
        }
    }

    $sql = "INSERT INTO residents 
    (resident_code, first_name, last_name, gender, birth_date, age, contact_number, address, barangay, city, profile_image)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['resident_code'],
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['gender'],
        $_POST['birth_date'],
        $_POST['age'],
        $_POST['contact_number'],
        $_POST['address'],
        $_POST['barangay'],
        $_POST['city'],
        $profile_image
    ]);

    header("Location: notifications.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Resident</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Add Resident</h3>

    <!-- Add enctype to allow file uploads -->
    <form method="POST" enctype="multipart/form-data">
        <input name="resident_code" class="form-control mb-2" placeholder="Resident Code" required>
        <input name="first_name" class="form-control mb-2" placeholder="First Name" required>
        <input name="last_name" class="form-control mb-2" placeholder="Last Name" required>

        <select name="gender" class="form-control mb-2" required>
            <option value="">Select Gender</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
        </select>

        <input type="date" name="birth_date" class="form-control mb-2" required>
        <input type="number" name="age" class="form-control mb-2" placeholder="Age" required>

        <input name="contact_number" class="form-control mb-2" placeholder="Contact Number" required>
        <input name="address" class="form-control mb-2" placeholder="Address" required>
        <input name="barangay" class="form-control mb-2" placeholder="Barangay" required>
        <input name="city" class="form-control mb-2" placeholder="City" required>

        <!-- NEW: Profile Image -->
        <label class="form-label">Profile Image</label>
        <input type="file" name="profile_image" class="form-control mb-3" accept="image/*" capture="environment">

        <button class="btn btn-success">Save</button>
        <a href="notifications.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
