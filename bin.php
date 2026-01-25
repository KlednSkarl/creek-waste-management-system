<?php

 
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$conn = $database->connect();

$emergencies = [];

try {
    $stmt = $conn->prepare("SELECT * FROM emergency ORDER BY reported_date DESC");
    $stmt->execute();
    $emergencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
 



session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emergency Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

 
</head>
 

<body>
<a href="dashboard.php" class="btn btn-secondary">Back</a>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr >
            <th>Resident Code</th>
            <th>Emergency Type</th>
            <th>Description</th>
            <th>Status</th>
            <th>Date Reported</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($emergencies as $row): ?>
     
 <tr class="table-row"
    data-bs-toggle="modal"
    data-bs-target="#detailModal"
    data-code="<?= htmlspecialchars($row['resident_code']) ?>"
    style="cursor:pointer;">
    
            <td><?= htmlspecialchars($row['resident_code']) ?></td>
            <td><?= htmlspecialchars($row['emergency_type']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['emergency_status']) ?></td>
            <td><?= htmlspecialchars($row['reported_date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Resident Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          
          <!-- Profile Image -->
          <div class="col-md-4 text-center">
            <img id="rImage" class="img-fluid rounded mb-3"
                 src="assets/default.png" alt="Profile Image">
          </div>

          <!-- Info -->
          <div class="col-md-8">
            <p><strong>Resident Code:</strong> <span id="rCode"></span></p>
            <p><strong>Name:</strong> <span id="rName"></span></p>
            <p><strong>Gender:</strong> <span id="rGender"></span></p>
            <p><strong>Birth Date:</strong> <span id="rBirth"></span></p>
            <p><strong>Age:</strong> <span id="rAge"></span></p>
            <p><strong>Contact:</strong> <span id="rContact"></span></p>
            <p><strong>Email:</strong> <span id="rEmail"></span></p>
            <p><strong>Address:</strong> <span id="rAddress"></span></p>
            <p><strong>Registered At:</strong> <span id="rRegistered"></span></p>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>





<script>
document.querySelectorAll('.table-row').forEach(row => {
    row.addEventListener('click', () => {

        const code = row.dataset.code;

        fetch(`fetch_resident.php?code=${code}`)
            .then(res => res.json())
            .then(data => {

                document.getElementById('rCode').textContent = data.resident_code;
                document.getElementById('rName').textContent =
                    data.first_name + ' ' + data.last_name;
                document.getElementById('rGender').textContent = data.gender;
                document.getElementById('rBirth').textContent = data.birth_date;
                document.getElementById('rAge').textContent = data.age;
                document.getElementById('rContact').textContent = data.contact_number;
                document.getElementById('rEmail').textContent = data.email;
                document.getElementById('rAddress').textContent =
                    `${data.address}, ${data.barangay}, ${data.city}`;
                document.getElementById('rRegistered').textContent = data.registered_at;

                document.getElementById('rImage').src =
                    data.profile_image
                        ?  encodeURI(data.profile_image)
                        : 'assets/default.png';
            })
            .catch(() => {
                alert("Unable to load resident data.");
            });

    });
});
</script>



 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
