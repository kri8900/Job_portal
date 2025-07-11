<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <?php
session_start();
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>

</head>
<link rel="stylesheet" href="styleSitemap.css">
<body>
    <div class="sitemap-bg-container  ">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-4">
                    <h1 class="Sitemap-main-heading">Sitemap</h1>
                </div>
                <div class="col-6 col-md-3">
                    <h1 class="sitemap-links-heading">Information</h1>
                    <ul class="sitemap-liks-list">
                        <li><a href="index1.php">Home</a></li>
                        <li><a href="index1.php">About Us</a></li>
                        <li><a href="jobs.html">Career with us</a></li>
                        <li><a href="https://github.com/NoumanKhan2003">Contact Us</a></li>
                        <li><a href="terms.html">Terms & Conditions</a></li>
                        <li><a href="privacyPolicy.html">Privacy Policy</a></li>
                        <li><a href="feedback.html">Feedback</a></li>
                    </ul>
                    <h1 class="sitemap-links-heading">Job Seekers Section</h1>
                    <ul class="sitemap-liks-list">
                        <li><a href="register.html">Register</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="index1.php">Advanced Search</a></li>
                        <li><a href="jobs.html">Create Job Alert</a></li>
                        <li><a href="privacyPolicy.html">Jobseekers FAQs</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h1 class="sitemap-links-heading">Browse Jobs</h1>
                    <ul class="sitemap-liks-list">
                        <li><a href="index1.php">IIM Jobs</a></li>
                        <li><a href="index1.php">IIT Jobs</a></li>
                        <li><a href="index1.php">Government Jobs</a></li>
                        <li><a href="index1.php">International Jobs</a></li>
                        <li><a href="index1.php">Browse Jobs</a></li>
                        <li><a href="index1.php">Browse Jobs by Designation</a></li>
                        <li><a href="index1.php">Browse Jobs by Skill</a></li>
                        <li><a href="index1.php">Browse Jobs by FA/Industry</a></li>
                        <li><a href="index1.php">Browse Jobs by Company</a></li>
                        <li><a href="index1.php">Browse Jobs by Location</a></li>
                    </ul>
                    <h1 class="sitemap-links-heading">CarrierUp Navigator</h1>
                    <ul class="sitemap-liks-list">
                        <li><a href="index1.php">Career Navigator</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h1 class="sitemap-links-heading">CarrierUp Fast Forward</h1>
                    <ul class="sitemap-liks-list">
                        <li><a href="resume.html">Resume Writing</a></li>
                        <li><a href="resume.html">Resume Samples</a></li>
                        <li><a href="resume.html">Resume Sample for Freshers</a></li>
                        <li><a href="resume.html">Visual Resume Samples</a></li>
                        <li><a href="resume.html">Cover Letter Samples</a></li>
                        <li><a href="resume.html">Job Letter Samples</a></li>
                        <li><a href="resume.html">Resume Quality Score</a></li>
                        <li><a href="jobs.html">Recruiter Connection</a></li>
                        <li><a href="jobs.html">Jobs4U</a></li>
                        <li><a href="jobs.html">Career Advice</a></li>
                        <li><a href="">FAQs</a></li>
                        <li><a href="https://github.com/NoumanKhan2003">Contact us</a></li>
                    </ul>
                    <h1 class="sitemap-links-heading">CarrierUp Learning</h1>
                    <ul class="sitemap-liks-list">
                        <li><a href="jobs.html">Online Courses & Certifications</a></li>
                        <li><a href="">Online Courses</a></li>
                        <li><a href="">Online Aptitude Test</a></li>
                        <li><a href="">Career Advice</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h1 class="sitemap-links-heading">CarrierUp Recruiter</h1>
                    <ul class="sitemap-liks-list">
                        <li><a href="login.html">Register/ Login</a></li>
                    </ul>
                    <h1 class="sitemap-links-heading">CarrierUp Recruiter</h1>
                    <ul class="sitemap-liks-list">
                        <li><a href="">Register</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="">Recruiters FAQs</a></li>
                    </ul>
                    <h1 class="sitemap-links-heading">Recruiters Products</h1>
                    <ul class="sitemap-liks-list">
                        <li><a href="">Buy Online</a></li>
                        <li><a href="">Post Jobs</a></li>
                        <li><a href="">Access Database</a></li>
                        <li><a href="">Job Advertisement</a></li>
                        <li><a href="">eApps Pro</a></li>
                        <li><a href="">Insta Hire</a></li>
                        <li><a href="">HR Zone</a></li>
                        <li><a href="">Career Site Manager</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>    
</body>
</html>