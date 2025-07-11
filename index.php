<?php
include "config.php";
session_start();

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="index.js"></script>
    <link rel="stylesheet" href="styleIndex.css">
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
                            <a class="nav-link active" aria-current="page" href="login.html">Jobs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Resume</a>
                        </li>
                        <?php
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                            echo '<li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>';
                            echo '<li class="nav-item"><a class="nav-link logout-button" href="logout.php">Logout</a></li>';
                        } else {
                            echo '<div class="nav-buttons">
                                    <a href="login.html"><button type="button" class="buttons" id="login">Login</button></a>
                                    <a href="register.html"><button type="button" class="buttons" id="register">Register</button></a>
                                  </div>';
                            echo '<li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    For Employers
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="employerRegister.html">Employer Registration</a></li>
                                    <li><a class="dropdown-item" href="employerLogin.html">Employer Login</a></li>
                                </ul>
                            </li>';
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <h1>Find your dream job now</h1>
        <h3 class="h3tag">"Connecting Talent with Opportunity — Seamlessly"</h3>

        <?php
            include "config.php";
            $skills = isset($_GET['skills']) ? $_GET['skills'] : '';
            $jobType = isset($_GET['job-type']) ? $_GET['job-type'] : '';
            $location = isset($_GET['location']) ? $_GET['location'] : '';
            ?>
        <form action="login.html" method="get" class="my-4">
        <div id="search-container">
        <div class="search-bar">
                    <input type="text" name="skills" class="form-control me-2 mb-2" placeholder="Enter companies" value="<?php echo htmlspecialchars($skills); ?>">
                    <div class="divider"></div>
                    <select name="job-type" class="form-select me-2 mb-2">
                        <option value="">Select Job Type</option>
                        <option value="full-time" <?php if ($jobType == 'full-time') echo 'selected'; ?>>Full-time</option>
                        <option value="part-time" <?php if ($jobType == 'part-time') echo 'selected'; ?>>Part-time</option>
                        <option value="contract" <?php if ($jobType == 'contract') echo 'selected'; ?>>Contract</option>
                        <option value="internship" <?php if ($jobType == 'internship') echo 'selected'; ?>>Internship</option>
                    </select>
                    <div class="divider"></div>
                    <input type="text" name="location" class="form-control me-2 mb-2" placeholder="Enter location" value="<?php echo htmlspecialchars($location); ?>">
                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                </div>
            </form>
            </div>
        </div>
        <h4>Top Companies Hiring Now</h4>
        <div id="carouselExampleControls" class="carousel slide">
            <div class="carousel-inner">
                <?php
                $sql = "SELECT id, job_title, company_name, location, job_type, salary, job_description FROM jobs ORDER BY RAND() LIMIT 8";
                $result = $conn->query($sql);

                $isActive = true;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $activeClass = $isActive ? 'active' : '';
                        $isActive = false;
                        echo '<div class="carousel-item ' . $activeClass . '">';
                        echo '  <div class="card">';
                        echo '    <div class="card-body">';
                        echo '      <h5 class="card-title">' . $row["job_title"] . '</h5>';
                        echo '      <p class="card-text">Company: ' . $row["company_name"] . '</p>';
                        echo '      <p class="card-text">Location: ' . $row["location"] . '</p>';
                        echo '      <p class="card-text">Type: ' . $row["job_type"] . '</p>';
                        echo '      <p class="card-text">Salary: ' . $row["salary"] . '</p>';
                        echo '      <p class="card-text">' . $row["job_description"] . '</p>';
                        echo '      <a href="Login.html?job_id=' . $row["id"] . '" class="btn btn-primary">Apply Now</a>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="carousel-item active">';
                    echo '  <div class="card">';
                    echo '    <div class="card-body">';
                    echo '      <p class="card-text">No job listings available</p>';
                    echo '    </div>';
                    echo '  </div>';
                    echo '</div>';
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="view-all-comp"><a href="login.html"><button type="button" class="button">View all Jobs</button></a>
        </div>

        <div class="container my-5">
            <h2>Upcoming events and challenges</h2>
            <div class="row">
                <div class="col-md-4">
                    <img src="pics/events.jpg" alt="Event Image" class="img-fluid" id="eventPic">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <?php
                        $sql = "SELECT id, event_title, company_name, date, lastDate, event_type, prizes, event_description FROM events ORDER BY date ASC LIMIT 4";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="col-md-6 mb-4">';
                                echo '  <div class="card">';
                                echo '    <div class="card-header">';
                                echo '      <small class="text-muted">Entry closes on ' . date('jS F, Y', strtotime($row["lastDate"])) . '</small>';
                                echo '      <span class="badge bg-primary float-end">' . $row["event_type"] . '</span>';
                                echo '    </div>';
                                echo '    <div class="card-body">';
                                echo '      <h5 class="card-title">' . $row["event_title"] . '</h5>';
                                echo '      <p class="card-text"> Company : ' . $row["company_name"] . '</p>';
                                echo '      <p class="card-text">' . $row["event_description"] . '</p>';
                                echo '      <p class="card-text">Prizes: ' . $row["prizes"] . '</p>';
                                echo '      <a href="login.html?event_id=' . $row["id"] . '" class="btn btn-primary">Enroll Now</a>';
                                echo '    </div>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="col-md-12">';
                            echo '  <p>No upcoming events available.</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

        <div class="view-all-comp"><a href="login.html"><button type="button" class="button">View all Events</button></a></div>

        <footer class="footer mt-auto py-3 bg-light">
            <div class="container-footer">
                <div class="row">
                    <div class="col-md-3" id="connect-with-us">
                        <img src="pics/findjob.png" alt="CarrierUp" class="img-fluid mb-3" id="img2">
                        <p id="p1">Connect with us</p>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/krishnaraj.kumar.1690"><i class="fa fa-facebook"></i></a>
                            <a href="https://www.instagram.com/kmkumar9750/"><i class="fa fa-instagram"></i></a>
                            <a href="https://github.com/kri8900"><i class="fa fa-github"></i></a>
                            <a href="https://www.linkedin.com/in/krishna-kumar-44a17a21b/"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="login.html">About us</a></li>
                            <li><a href="login.html">Careers</a></li>
                            <li><a href="employerLogin.html">Employer home</a></li>
                            <li><a href="login.html">Sitemap</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="login.html">Feedback</a></li>
                            <li><a href="notice.html">Summons/Notices</a></li>
                            <li><a href="grievances.html">Grievances</a></li>
                            <li><a href="report.html">Report issue</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="login.html">Privacy policy</a></li>
                            <li><a href="login.html">Terms & conditions</a></li>
                            <li><a href="login.html">Fraud alert</a></li>
                            <li><a href="login.html">Trust & safety</a></li>
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
</body>

</html>