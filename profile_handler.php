<?php
include "config.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}

$email = $_SESSION['email']; 
$name = $_POST['name'];
$skills = $_POST['skills'];
$experience = $_POST['experience'];
$education = $_POST['education'];
$certifications = $_POST['certifications'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO job_seekers_profiles (name, email, skills, experience, education, certifications) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE name=?, skills=?, experience=?, education=?, certifications=?");
$stmt->bind_param("sssssssssss", $name, $email, $skills, $experience, $education, $certifications, $name, $skills, $experience, $education, $certifications);

if ($stmt->execute()) {
    header("Location: index1.php"); 
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
