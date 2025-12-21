<?php
session_start();

/* Protect the page */
  if (!isset($_SESSION['username'])) {
      header("Location: login.php");
      exit();
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creek Monitoring Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Creek Monitoring System</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="creek.php">Water Level</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bin.php">Emergency Assistance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="conveyor_status.php">Rainfal Event History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="notifications.php">Residence Registration</a>
                </li>
            
            </ul>

            <span class="navbar-text text-white me-3">
                Welcome, <?= htmlspecialchars($_SESSION['username']); ?>
            </span>

            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container mt-4">

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">Creek Water Level</h5>
                    <p class="card-text">Current Level: <strong>Normal</strong></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">Trash Bin Fill</h5>
                    <p class="card-text">Fill Status: <strong>65%</strong></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">Conveyor Motor</h5>
                    <p class="card-text">Status: <strong class="text-success">Running</strong></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">Alerts</h5>
                    <p class="card-text">No active alerts</p>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>