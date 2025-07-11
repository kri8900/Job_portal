<?php
include "config.php";

// Create the database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}
$conn->select_db($dbname);

// Create the event_applications table if it does not exist
$sql = "CREATE TABLE IF NOT EXISTS event_applications (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INT(6) UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    if ($event_id === null) {
        die("Error: event ID is missing.");
    }

    $sql = "SELECT COUNT(*) AS count FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        die("Error: event ID does not exist.");
    }

    $stmt = $conn->prepare("INSERT INTO event_applications (event_id, name, mobile, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $event_id, $name, $mobile, $email);

    if ($stmt->execute()) {
        header("Location: index1.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $event_id = isset($_GET['event_id']) ? htmlspecialchars($_GET['event_id']) : '';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Apply for Event</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            body {
                background-image: url('https://th.bing.com/th/id/OIP.B8SiYe2rUIYdtP2NAjkHewHaE8?rs=1&pid=ImgDetMain');
                background-size: cover;
                font-family: 'Roboto', sans-serif;
            }
            .registration-page-background {
                padding-top: 5rem;
                padding-bottom: 5rem;
            }
            .registration-form {
                background: rgba(255, 255, 255, 0.8);
                padding: 2rem;
                border-radius: 8px;
            }
            .registration-form-heading {
                text-align: center;
                margin-bottom: 1rem;
            }
            .form-name {
                font-weight: bold;
                margin-top: 1rem;
            }
            .r-form-fill-box {
                width: 100%;
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="registration-page-background">
            <div class="container">
                <div class="row d-flex flex-row justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="registration-form">
                            <h1 class="registration-form-heading">Enroll for Event</h1>
                            <form id="registrationForm" action="applyevents.php" method="post">
                                <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                                <p class="form-name">Full Name:</p>
                                <input type="text" class="r-form-fill-box" name="name" placeholder="Full Name" required>
                                <p class="form-name">Mobile Number:</p>
                                <input type="text" class="r-form-fill-box" name="mobile" placeholder="Mobile Number" required>
                                <p class="form-name">Email:</p>
                                <input type="email" class="r-form-fill-box" name="email" placeholder="Email" required>
                                <button type="submit" class="btn btn-primary">Submit Enrollment</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}
$conn->close();
?>
