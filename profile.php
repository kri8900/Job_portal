<?php
include "config.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}

$email = $_SESSION['email']; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);
$tableCreationQuery = "CREATE TABLE IF NOT EXISTS job_seekers_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    skills TEXT,
    experience TEXT,
    education TEXT,
    certifications TEXT
)";
$conn->query($tableCreationQuery);

$stmt = $conn->prepare("SELECT * FROM job_seekers_profiles WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = array(
        'name' => '',
        'email' => $email,
        'skills' => '',
        'experience' => '',
        'education' => '',
        'certifications' => ''
    );
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styleProfile.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Profile Status</h1>
        </header>

        <section id="job-seekers">
            <h2>Job Seekers</h2>
            <form class="profile-form" action="profile_handler.php" method="post">
                <h3>Personal Details</h3>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php echo htmlspecialchars($user['name']); ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>

                <h3>Skills</h3>
                <label for="skills">Skills</label>
                <input type="text" id="skills" name="skills" placeholder="Enter your skills" value="<?php echo htmlspecialchars($user['skills']); ?>">

                <h3>Experience</h3>
                <label for="experience">Experience</label>
                <textarea id="experience" name="experience" placeholder="Enter your experience"><?php echo htmlspecialchars($user['experience']); ?></textarea>

                <h3>Education</h3>
                <label for="education">Education</label>
                <textarea id="education" name="education" placeholder="Enter your education"><?php echo htmlspecialchars($user['education']); ?></textarea>

                <h3>Certifications</h3>
                <label for="certifications">Certifications</label>
                <textarea id="certifications" name="certifications" placeholder="Enter your certifications"><?php echo htmlspecialchars($user['certifications']); ?></textarea>

                <button type="submit">Submit</button>
            </form>
        </section>
    </div>
</body>
</html>
