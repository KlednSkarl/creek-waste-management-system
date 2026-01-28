<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Water Alert Levels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<a href="dashboard.php" class="btn btn-secondary">Back</a>
<div class="container py-5">
    <h3 class="mb-4 text-center fw-bold">Water Level Alert System</h3>

    <div class="row g-4">

        <!-- Alert Level 1 -->
        <div class="col-md-6">
            <div class="card border-success shadow-sm">
                <div class="card-header bg-success text-white fw-bold">
                    Alert Level 1 – Normal
                </div>
                <div class="card-body">
                    <p><strong>Water Level:</strong> Low to normal</p>
                    <p><strong>Risk:</strong> Minimal</p>
                    <p>
                        Water remains within normal range and riverbanks.
                        No flooding is expected. Continuous monitoring is
                        maintained to detect any sudden changes.
                    </p>
                </div>
            </div>
        </div>

        <!-- Alert Level 2 -->
        <div class="col-md-6">
            <div class="card border-warning shadow-sm">
                <div class="card-header bg-warning fw-bold">
                    Alert Level 2 – Advisory
                </div>
                <div class="card-body">
                    <p><strong>Water Level:</strong> Rising</p>
                    <p><strong>Risk:</strong> Low to Moderate</p>
                    <p>
                        Water level is increasing due to rainfall or upstream
                        flow. Flooding is not imminent, but residents are
                        advised to stay alert and prepare.
                    </p>
                </div>
            </div>
        </div>

        <!-- Alert Level 3 -->
        <div class="col-md-6">
            <div class="card border-orange shadow-sm">
                <div class="card-header bg-orange text-white fw-bold" style="background-color:#fd7e14;">
                    Alert Level 3 – Warning
                </div>
                <div class="card-body">
                    <p><strong>Water Level:</strong> Near critical</p>
                    <p><strong>Risk:</strong> High</p>
                    <p>
                        Water has reached or is close to the danger threshold.
                        Minor flooding may occur in low-lying areas.
                        Immediate precautions are required.
                    </p>
                </div>
            </div>
        </div>

        <!-- Alert Level 4 -->
        <div class="col-md-6">
            <div class="card border-danger shadow-sm">
                <div class="card-header bg-danger text-white fw-bold">
                    Alert Level 4 – Critical
                </div>
                <div class="card-body">
                    <p><strong>Water Level:</strong> Extremely high</p>
                    <p><strong>Risk:</strong> Severe / Life-threatening</p>
                    <p>
                        Water level has exceeded safe limits and severe flooding
                        is occurring. Immediate evacuation and emergency
                        response are required.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
