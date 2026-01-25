<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . "/config/Database.php";

$db = new Database();
$conn = $db->connect();

/* ======================
   CREATE
====================== */
if (isset($_POST['add'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO users (username, password) VALUES (:username, :password)"
    );
    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);
}

/* ======================
   UPDATE
====================== */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = trim($_POST['username']);

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username=:username, password=:password WHERE id=:id";
        $params = [':username'=>$username, ':password'=>$password, ':id'=>$id];
    } else {
        $sql = "UPDATE users SET username=:username WHERE id=:id";
        $params = [':username'=>$username, ':id'=>$id];
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
}

/* ======================
   DELETE
====================== */
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=:id");
    $stmt->execute([':id' => $_GET['delete']]);
}

/* ======================
   READ
====================== */
$stmt = $conn->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User CRUD</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<a href="dashboard.php" class="btn btn-secondary">Back</a>
<div class="container mt-5">

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">User Management</h4>
        </div>

        <div class="card-body">

            <!-- ADD USER -->
            <form method="POST" class="row g-2 mb-4">
                <div class="col-md-4">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="col-md-4">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="col-md-4">
                    <button name="add" class="btn btn-success w-100">Add User</button>
                </div>
            </form>

            <!-- USERS TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="35%">Username</th>
                            <th width="40%">Password</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($users as $user): ?>
                    <tr>
                        <form method="POST">
                            <td><?= $user['id'] ?></td>

                            <td>
                                <input type="text" name="username"
                                       value="<?= htmlspecialchars($user['username']) ?>"
                                       class="form-control" required>
                            </td>

                            <td>
                                <input type="password" name="password"
                                       class="form-control"
                                       placeholder="Leave blank to keep current">
                            </td>

                            <td class="text-center">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button name="update" class="btn btn-warning btn-sm mb-1">Edit</button>
                                <a href="?delete=<?= $user['id'] ?>"
                                   class="btn btn-danger btn-sm mb-1"
                                   onclick="return confirm('Delete this user?')">
                                   Delete
                                </a>
                            </td>
                        </form>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (count($users) === 0): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No users found</td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

</body>
</html>
