<?php
 

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <!-- ABOUT SECTION -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-primary text-white">
            ℹ️ About the System
        </div>
        <div class="card-body">
            <p class="mb-0">
                This system is designed to help residents report emergencies
                efficiently and allow barangay responders to act quickly.
                It improves communication, tracking, and response time
                during disasters and urgent situations.
            </p>
        </div>
    </div>

    <!-- FAQ SECTION -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-warning">
             Frequently Asked Questions
        </div>
        <div class="card-body">

            <strong>Q: Who can use this system?</strong>
            <p>Registered residents of the barangay.</p>

            <strong>Q: What emergencies can I report?</strong>
            <p>Flood, injury, rescue, evacuation, and other urgent concerns.</p>

            <strong>Q: Is my information secure?</strong>
            <p>Yes. Your data is protected and only visible to authorized personnel.</p>

        </div>
    </div>

    <!-- TRAINING SECTION -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-success text-white">
             Training & Safety Guidelines
        </div>
        <div class="card-body">
            <ul>
                <li>Remain calm during emergencies</li>
                <li>Follow instructions from responders</li>
                <li>Know your evacuation routes</li>
                <li>Keep emergency contacts ready</li>
                <li>Report accurate information only</li>
            </ul>
        </div>
    </div>

    <!-- BACK BUTTON -->
    <a href="add_emergency.php" class="btn btn-secondary w-100">
         Back
    </a>

</div>

</body>
</html>
