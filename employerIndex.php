<?php
include "config.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindJob.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z4G4fA7+7DXt659Q6S/ahlWXIC/0mV5QVF3l0uFI0Rt66r9wBorAI7p6SB6b7R9gqxD0yIrO0DkF1cJ55n1Yq/0"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styleEmployerIndex.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <p class="navbar-brand"> <img src="pics/findjob.png" alt="CarrierUp" id="img1"></p>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="jobs.php">Jobs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="events.php">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="postJob.html">Post-Job</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="postEvent.html">Post-Event</a>
                        </li>
                        <?php
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                            echo '<li class="nav-item"><a class="nav-link logout-button" href="logout.php">Logout</a></li>';
                        }
                        ?>
                     </ul>
                </div>
            </div>
        </nav>
    </header>

<main>  
        <div class="main-container">
            <div class="main-content">
                <h1>Let's hire your next great candidate in Just a step</h1>
                <a href="postJob.html"><button id="post-job-button">Post a job</button></a>
            </div>
            <div class="picture-container">
                <img src="pics/job24.jpg" alt="Hiring Image">
            </div>
        </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
            <div class="container-footer">
                <div class="row">
                    <div class="col-md-3" id="connect-with-us">
                        <img src="pics/findjob.png" alt="CarrierUp" class="img-fluid mb-3" id="img2">
                        <p id="p1">Connect with us</p>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/profile.php?id=100013915323747"><i class="fa fa-facebook"></i></a>
                            <a href="https://www.instagram.com/nouman_khan_innocent?igsh=MTE2NGRsYW84OGF2Mg=="><i class="fa fa-instagram"></i></a>
                            <a href="https://github.com/NoumanKhan2003"><i class="fa fa-github"></i></a>
                            <a href="https://www.linkedin.com/in/nouman-khan-95923a256?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="https://www.infoedge.in/">About us</a></li>
                            <li><a href="https://careers.infoedge.com/#!/">Careers</a></li>
                            <li><a href="employerIndex.php">Employer home</a></li>
                            <li><a href="sitemap.php">Sitemap</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="feedback.html">Feedback</a></li>
                            <li><a href="notice.html">Summons/Notices</a></li>
                            <li><a href="grievances.html">Grievances</a></li>
                            <li><a href="report.html">Report issue</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="privacyPolicy.html">Privacy policy</a></li>
                            <li><a href="terms.html">Terms & conditions</a></li>
                            <li><a href="fraudAlert.html">Fraud alert</a></li>
                            <li><a href="trustAndSafety.html">Trust & safety</a></li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row mt-4">
                        <div class="p2">
                                <p id="p2">All trademarks are the property of their respective owners</p>
                                <p id="p2">All rights reserved © 2025 FindJob (India) Pvt. Ltd.</p>
                    </div>
                </div>
            </div>
        </footer>
    </main>
</body>

</html>