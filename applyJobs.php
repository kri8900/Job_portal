<?php
include "config.php";

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}
$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS job_applications (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT(6) UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    resume_path VARCHAR(255) NOT NULL,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_id = isset($_POST['job_id']) ? $_POST['job_id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    if ($job_id === null) {
        die("Error: Job ID is missing.");
    }

    echo "Debug: Job ID = $job_id<br>";

    $sql = "SELECT COUNT(*) AS count FROM jobs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        die("Error: Job ID does not exist.");
    }

    // Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['resume']['tmp_name'];
        $file_name = basename($_FILES['resume']['name']);
        $upload_dir = 'uploads/';
        $file_path = $upload_dir . $file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (move_uploaded_file($file_tmp, $file_path)) {
            $stmt = $conn->prepare("INSERT INTO job_applications (job_id, name, mobile, email, resume_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $job_id, $name, $mobile, $email, $file_path);

            if ($stmt->execute()) {
                header("Location: index1.php"); 
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
} else {
    $job_id = isset($_GET['job_id']) ? htmlspecialchars($_GET['job_id']) : '';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Apply for Job</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="styleRegister.css">
    </head>
    <body>
        <div class="registration-page-background pt-5 pb-5">
            <div class="container">
                <div class="row d-flex flex-row justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="registration-form">
                            <h1 class="registration-form-heading">Apply Here</h1>
                            <form id="registrationForm" action="applyJobs.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job_id); ?>">
                                <p class="form-name">Full Name:</p>
                                <input type="text" class="r-form-fill-box" name="name" placeholder="Full Name" required>
                                <p class="form-name">Mobile Number:</p>
                                <input type="text" class="r-form-fill-box" name="mobile" placeholder="Mobile Number" required>
                                <p class="form-name">Email:</p>
                                <input type="email" class="r-form-fill-box" name="email" placeholder="Email" required>
                                <p class="form-name">Attach Resume:</p>
                                <input type="file" class="r-form-fill-box" name="resume" required>
                                <button type="submit" class="btn btn-primary">Submit Application</button>
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
