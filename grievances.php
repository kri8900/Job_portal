<?php
session_start();
include "config.php";

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS grievances (
    id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    number VARCHAR(20) NOT NULL,
    portal VARCHAR(50) NOT NULL,
    url VARCHAR(255) NOT NULL,
    reason VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    file TEXT,
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

$result = $conn->query("SHOW COLUMNS FROM grievances LIKE 'file'");
if ($result->num_rows === 0) {

    $alter_sql = "ALTER TABLE grievances ADD COLUMN file TEXT";
    if ($conn->query($alter_sql) !== TRUE) {
        die("Error adding 'file' column: " . $conn->error);
    }
}

$file = '';
$allowed_types = ['application/pdf', 'image/jpeg', 'image/png'];

if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
    $target_dir = "uploads/";
    $file_name = basename($_FILES['file']['name']);
    $target_file = $target_dir . $file_name;
    $file_type = $_FILES['file']['type'];
    $file_error = $_FILES['file']['error'];
    $file_tmp = $_FILES['file']['tmp_name'];

    if ($file_error === UPLOAD_ERR_OK) {
        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($file_tmp, $target_file)) {
                $file = $target_file;
            } else {
                echo "Error moving uploaded file: $file_name<br>";
            }
        } else {
            echo "Unsupported file type: $file_type<br>";
        }
    } else {
        echo "Error uploading file: $file_name, error code: $file_error<br>";
    }
} else {
    echo "No file uploaded.<br>";
}

$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$number = $conn->real_escape_string($_POST['number']);
$portal = $conn->real_escape_string($_POST['portal']);
$url = $conn->real_escape_string($_POST['url']);
$reason = $conn->real_escape_string($_POST['reason']);
$description = $conn->real_escape_string($_POST['description']);

$sql = "INSERT INTO grievances (name, email, number, portal, url, reason, description, file)
VALUES ('$name', '$email', '$number', '$portal', '$url', '$reason', '$description', '$file')";

if ($conn->query($sql) === TRUE) {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header("Location: index1.php");
    } else {
        header("Location: index.php");
    } }
    else { 
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
