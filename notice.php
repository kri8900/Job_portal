<?php
session_start(); // Start the session at the beginning

include "config.php";

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS notices (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    issues VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    reasons TEXT NOT NULL,
    details TEXT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $issues = $_POST['issues'];
    $url = $_POST['url'];
    $details = $_POST['details'];

    $reasons = [];
    for ($i = 1; $i <= 10; $i++) {
        if (isset($_POST["check$i"])) {
            $reasons[] = $_POST["check$i"];
        }
    }

    if (!empty($_POST['others'])) {
        $reasons[] = 'Other: ' . $_POST['others'];
    }

    $reasons = implode(", ", $reasons);

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["uploads"]["name"]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $valid_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    if (!in_array($file_type, $valid_extensions)) {
        die("Invalid file type. Only JPG, JPEG, PNG, GIF, and PDF files are allowed.");
    }

    if ($_FILES["uploads"]["size"] > 10000000) {
        die("Sorry, your file is too large. Maximum size is 10 MB.");
    }

    if (!move_uploaded_file($_FILES["uploads"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    $stmt = $conn->prepare("INSERT INTO notices (name, email, issues, url, reasons, details, file_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $issues, $url, $reasons, $details, $target_file);

    if ($stmt->execute() === TRUE) {
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            header("Location: index1.php");
        } else {
            header("Location: index.php");
        }
        $stmt->close();
        exit();
        
    } else {
        $stmt->close();
        die("Error: " . $stmt->error);
    }

}

$conn->close();
?>
