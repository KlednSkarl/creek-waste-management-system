<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Risk Management System</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            scroll-behavior: smooth;
        }
        section {
            scroll-margin-top: 80px;
        }
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('https://images.unsplash.com/photo-1581091870627-3e0d7f9c7cbb') center/cover no-repeat;
            height: 100vh;
            color: #fff;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#home">HydroGuard 180</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#training">Training</a></li>
                <li class="nav-item"><a class="nav-link" href="#login">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO / LANDING SECTION -->
<section id="home" class="hero d-flex align-items-center">
    <div class="container text-center">
        <h1>HydroGuard 180</h1>
        <p class="lead mt-3">
            Proactively identify, assess, and mitigate risks to ensure safety,
            preparedness, and informed decision-making.
        </p>
        <a href="#login" class="btn btn-primary btn-lg mt-4">Get Started</a>
    </div>
</section>



<!-- ABOUT SECTION -->
<section id="about" class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4>About Risk Management</h4>
                <p>
                    Risk management is a structured approach to identifying,
                    evaluating, and controlling threats to an organization’s
                    capital and earnings.
                </p>
                <p>
                    It ensures operational resilience, compliance, and public
                    safety through proactive planning and response strategies.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://images.unsplash.com/photo-1600880292089-90a7e086ee0c"
                     class="img-fluid rounded shadow"
                     alt="Risk Management">
            </div>
        </div>
    </div>
</section>

<!-- FAQ SECTION -->
<section id="faq" class="py-5">
    <div class="container">
        <div class="card shadow-sm p-4">
            <h4 class="mb-3">Frequently Asked Questions</h4>

            <p><strong>What is risk?</strong><br>
            Risk is the possibility of an event causing harm or loss.</p>

            <p><strong>Why is risk management important?</strong><br>
            It helps prevent disasters, minimize losses, and improve response.</p>

            <p><strong>Who uses this system?</strong><br>
            Organizations, local governments, and safety teams.</p>
        </div>
    </div>
</section>

<!-- TRAINING SECTION -->
<section id="training" class="py-5 bg-white">
    <div class="container">
        <div class="row">
            <div class="col text-center mb-4">
                <h4>Risk Management Training</h4>
                <p class="text-muted">
                    Learn essential skills to manage risks effectively
                </p>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm p-3">
                    <h5>Risk Identification</h5>
                    <p>Recognize hazards and vulnerabilities early.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm p-3">
                    <h5>Risk Assessment</h5>
                    <p>Analyze likelihood and impact of risks.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm p-3">
                    <h5>Risk Mitigation</h5>
                    <p>Apply controls and response strategies.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- LOGIN SECTION -->
<section id="login" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow p-4">
                    <h3 class="text-center mb-4">Login</h3>

                    <form method="POST" action="login_process.php">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <?php
                    if (isset($_GET['error'])) {
                        echo '<div class="alert alert-danger mt-3 text-center">
                                Invalid login credentials
                              </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3">
    <small>© <?php echo date('Y'); ?> HydroGuard 180. All rights reserved.</small>
</footer>

<!-- Bootstrap JS (for navbar toggle only) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
