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
    $sql = "INSERT INTO residents 
    (resident_code, first_name, last_name, gender, birth_date, age, contact_number, address, barangay, city)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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

    <form method="POST">
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

        <button class="btn btn-success">Save</button>
        <a href="notifications.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
