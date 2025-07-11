<?php
session_start();
include 'config.php'; 

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS Reports(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    issue_type VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $issue_type = $conn->real_escape_string($_POST['issue-type']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO Reports (name, email, issue_type, description)
            VALUES ('$name', '$email', '$issue_type', '$description')";

    if ($conn->query($sql) === TRUE) {
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header("Location: index1.php");
    } else {
        header("Location: index.php");
    } } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
