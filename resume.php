<?php
include "config.php";

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    $conn->select_db($dbname);

    $sql = "CREATE TABLE IF NOT EXISTS resumes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        title VARCHAR(50) NOT NULL,
        profilePicture VARCHAR(100) NOT NULL,
        mobile VARCHAR(15) NOT NULL,
        email VARCHAR(50) NOT NULL,
        address VARCHAR(100) NOT NULL,
        about TEXT NOT NULL,
        education TEXT NOT NULL,
        skills TEXT NOT NULL,
        technologies TEXT NOT NULL,
        projects TEXT NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $title = $_POST['title'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $about = $_POST['about'];
            $education = $_POST['education'];
            $skills = $_POST['skills'];
            $technologies = $_POST['technologies'];
            $projects = $_POST['projects'];

            $profilePicture = $_FILES['profilePicture'];
            $profilePicturePath = 'uploads/' . basename($profilePicture['name']);
            move_uploaded_file($profilePicture['tmp_name'], $profilePicturePath);

            $stmt = $conn->prepare("INSERT INTO resumes (name, title, profilePicture, mobile, email, address, about, education, skills, technologies, projects) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $name, $title, $profilePicturePath, $mobile, $email, $address, $about, $education, $skills, $technologies, $projects);

            if ($stmt->execute()) {
                $skillsList = array_filter(array_map('trim', preg_split('/[\n,]+/', $skills)));
                $technologiesList = array_filter(array_map('trim', preg_split('/[\n,]+/', $technologies)));
                $educationList = array_filter(array_map('trim', preg_split('/[\n,]+/', $education)));
                $projectList = array_filter(array_map('trim', preg_split('/[\n,]+/', $projects)));

                echo "
          <html>
                <head>
                    <link rel='stylesheet' href='styleResume.css'>
                </head>
                <body>
                    <h1 id='heading'> Resume</h1>
                    <div class='resume'>
                        <div class='sidebar'>
                            <div class='profile'>
                                <img src='$profilePicturePath' alt='$name'>
                                <h1><strong>$name</strong></h1>
                                <h2>$title</h2>
                            </div>
                            <div class='contact'>
                                <h3><strong>Contact</strong></h3>
                                <p>Mobile: $mobile</p>
                                <p>Email: $email</p>
                                <p>Address: $address</p>
                            </div>
                        </div>
                        <div class='main'>
                            <div class='section'>
                                <h2>About me</h2>
                                <p>$about</p>
                            </div>
                            <div class='section'>
                                <h2>Education</h2>
                                <ul>";
                                foreach ($educationList as $education) {
                                    echo "<li>$education</li>";
                                }
                                echo "</ul>
                            </div>
                            <div class='section'>
                                <h2>Skills and Abilities</h2>
                                <ul>";
                                foreach ($skillsList as $skill) {
                                    echo "<li>$skill</li>";
                                }
                                echo "</ul>
                            </div>
                            <div class='section'>
                                <h2>Technologies</h2>
                                <ul>";
                                foreach ($technologiesList as $technology) {
                                    echo "<li>$technology</li>";
                                }
                                echo "</ul>
                            </div>
                            <div class='section'>
                                <h2>Projects</h2>
                                 <ul>";
                                 foreach ($projectList as $project) {
                                    echo "<li>$project</li>";
                                }
                                echo "</ul>
                            </div>
                        </div>
                    </div>
                    <div class='buttons'>
                        <button type='button' id='print'>Print</button>
                        <button type='button' id='home'>Home</button>
                    </div>
                    <script>
                        const printbtn = document.getElementById('print');
                        printbtn.addEventListener('click', function() {
                            window.print();
                        });
                        document.getElementById('home').addEventListener('click', function() {
                            window.location.href = 'index1.php';
                        });
                    </script>
                </body>
                </html>
                ";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
?>
