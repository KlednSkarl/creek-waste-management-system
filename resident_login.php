<?php
 

 
session_start();
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT resident_id, resident_code, first_name, last_name, password_hash
        FROM residents
        WHERE email = ?
        LIMIT 1
    ");
    $stmt->execute([$email]);
    $resident = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resident && password_verify($password, $resident['password_hash'])) {

        $_SESSION['resident_id']   = $resident['resident_id'];
        $_SESSION['resident_code'] = $resident['resident_code'];
        $_SESSION['resident_name'] = $resident['first_name'] . ' ' . $resident['last_name'];

        header("Location: add_emergency.php");
        exit;

    } else {
        $error = "Invalid login credentials.";
    }
}
 ?>

 
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="col-md-4 mx-auto card p-4 shadow">
        <h4 class="text-center mb-3">Resident Login</h4>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
            <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
            
            <button class="btn btn-danger w-100">Login</button>
            <a href="register_resident.php" class="btn btn-link w-100 mt-2">Create account</a>
        </form>
    </div>
</div>

</body>
</html>
