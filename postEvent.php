<?php
include "config.php";

$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS events (
    id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_title VARCHAR(100) NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    lastDate DATE NOT NULL,
    event_type VARCHAR(20) NOT NULL,
    prizes VARCHAR(255) NOT NULL,
    event_description TEXT
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

    $event_title = $_POST["event-title"];
    $company_name = $_POST["company-name"];
    $date = $_POST["date"];
    $lastDate = $_POST["lastDate"];
    $event_type = $_POST["event-type"];
    $prizes = $_POST["prizes"];
    $event_description = $_POST["event-description"];

    $sql = "INSERT INTO events (event_title, company_name, date, lastDate, event_type, prizes, event_description) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssds", $event_title, $company_name, $date, $lastDate, $event_type, $prizes, $event_description);
    $stmt->execute();

    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        header("Location: employerIndex.php");
        exit();
        }

$stmt->close();
$conn->close();
?>
