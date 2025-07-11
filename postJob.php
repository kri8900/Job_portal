<?php
include "config.php";
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$sql = "CREATE TABLE IF NOT EXISTS jobs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_title VARCHAR(255) NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    job_type ENUM('full-time', 'part-time', 'contract', 'internship') NOT NULL,
    salary VARCHAR(255) NOT NULL,
    job_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

$job_title = $_POST['job-title'];
$company_name = $_POST['company-name'];
$location = $_POST['location'];
$job_type = $_POST['job-type'];
$salary = $_POST['salary'];
$job_description = $_POST['job-description'];

$stmt = $conn->prepare("INSERT INTO jobs (job_title, company_name, location, job_type, salary, job_description) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $job_title, $company_name, $location, $job_type, $salary, $job_description);

if ($stmt->execute()) {
    header("Location: employerIndex.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
