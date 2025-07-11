<?php
include 'config.php';

$dbname = "job_portal";
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
} else {
    echo json_encode(["status" => "error", "message" => "Error creating database: " . $conn->error]);
    exit;
}

$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    rating ENUM('excellent', 'good', 'average', 'poor') NOT NULL,
    comments TEXT NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
} else {
    echo json_encode(["status" => "error", "message" => "Error creating table: " . $conn->error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $age = $conn->real_escape_string($_POST['age']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $rating = $conn->real_escape_string($_POST['rating']);
    $comments = $conn->real_escape_string($_POST['comments']);

    $sql = "INSERT INTO feedback (name, age, email, phone, rating, comments) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissss", $name, $age, $email, $phone, $rating, $comments);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "feedback submitted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
